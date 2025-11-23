<template>
    <ion-modal :is-open="isOpen" @didDismiss="closeModal" class="fullscreen-modal">
        <template v-if="this.course">
            <ion-header>
                <ion-toolbar>
                    <ion-title>COURSE {{ this.course.code }}</ion-title>
                    <ion-buttons slot="end">
                        <ion-button :strong="true" @click="closeModal()">
                            <i class="fa-solid fa-close" style="font-size: 1.4rem;"></i>
                        </ion-button>
                    </ion-buttons>
                </ion-toolbar>
            </ion-header>
            <ion-content class="ion-padding">
                <strong>Code: </strong> {{ this.course.code }} <br>
                <strong>Depart: </strong> {{ this.course.adresse_chargement }} ({{
                    formatDate(this.course.date_chargement) }}) <br>
                <strong>Destination: </strong> {{ this.course.adresse_dechargement }} ({{
                    formatDate(this.course.date_dechargement) }}) <br>
                <strong>Type de course: </strong> {{ this.course.type_course }} <br>
                <strong>Type de marchandise: </strong> {{ this.course.type_marchandise }} <br>
                <strong>Montant: </strong> {{ formatPriceWithDevise(this.course.trajet.montant) }} <br>
                <strong>Etat: </strong> {{ this.course.etat }} <br><br>

                <strong>Vehicule: </strong> {{ this.course.vehicule_plaque }} <br>
                <strong>Chauffeur principal: </strong> {{ this.course.chauffeur_principal_nom }} <br>
                <div v-if="this.course.chauffeur_secondaire_nom">
                    <strong>Chauffeur secondaire: </strong> {{ this.course.chauffeur_secondaire_nom }} <br>
                </div>


                <div class="row d-flex justify-content-center my-3">
                    <a v-if="this.course.etat == 'En cours'" :href="'tel:'+this.course.chauffeur_principal_telephone1"
                        class="btn btn-light btn-sm mr-2 col-auto mb-1">
                        <i class="fas fa-phone"></i> Apeller le chauffeur
                    </a>

                    <button v-if="this.course.etat == 'En cours'" type="button"
                        class="btn btn-light btn-sm mr-2 col-auto mb-1" @click="isModalSignalerOpen = true">
                        <i class="fas fa-ban"></i> Signaler un problèmes
                    </button>

                    <button v-if="this.course.etat == 'En cours'" type="button"
                        class="btn btn-light btn-sm mr-2 col-auto mb-1" @click="confirmDechargement()">
                        <i class="fas fa-dolly-flatbed"></i> Confirmer le dechargement
                    </button>
                    <button v-if="this.course.etat == 'Terminé'" class="btn btn-success btn-sm mr-2 col-auto mb-1">
                        <i class="fas fa-credit-card"></i> Payer
                    </button>

                    <button v-if="this.course.etat == 'Terminé'" type="button"
                        class="btn btn-light btn-sm mr-2 col-auto mb-1" @click="isModalGeolocOpen = true">
                        <i class="fa-solid fa-map-location-dot"></i> Trajet parcouru
                    </button>
                    <button v-else-if="this.course.etat == 'En cours'" type="button"
                        class="btn btn-light btn-sm mr-2 col-auto mb-1" @click="isModalGeolocOpen = true">
                        <i class="fa-solid fa-location-dot"></i> Localiser le vehicule
                    </button>

                    <button v-if="this.course.montant != this.course.reste_a_payer && this.course.etat == 'Terminé'"
                        type="button" class="btn btn-light btn-sm mr-2 col-auto mb-1">
                        <i class="fas fa-folder"></i> Consulter les paiements
                    </button>
                </div>



                <ModalSignaler :isOpen="isModalSignalerOpen" :course="this.course" @close="closeModalSignaler" /> 
                <ModalGeolocCourse :isOpen="isModalGeolocOpen" :course="this.course" @close="closeGeolocModal" />

            </ion-content>
        </template>
    </ion-modal>


</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';
import moment from 'moment'
import ModalSignaler from '../courses/ModalSignaler.vue';
import ModalGeolocCourse from '@/views/geolocalisation/ModalGeolocCourse.vue';

export default defineComponent({
    components: { ModalGeolocCourse, ModalSignaler },
    props: {
        isOpen: {
            type: Boolean,
            required: true
        },
        course: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            isLoading: false,
            isModalSignalerOpen: false,
            isModalGeolocOpen: false
        };
    },
    methods: {
        async presentToast(position: 'top' | 'middle' | 'bottom', msg, duration, color) {
            const toast = await toastController.create({
                message: msg,
                duration: duration,
                position: position,
                color: color
            });

            await toast.present();
        },
        formatDate(val) {
            if (val) return moment(String(val)).format('DD/MM/YYYY')
        },
        formatPriceWithDevise(val) {
            if (val) return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'XAF' }).format(val)
        },
        closeModalSignaler() {
            this.isModalSignalerOpen = false;
        },
        closeGeolocModal() {
            this.isModalGeolocOpen = false;
        },
        closeModal() {
            this.$emit('close');
        },
        confirmDechargement() {
            this.isLoading = true
            this.axios.post('/api/courses/' + this.course.id + '/confirm').then((response) => {
                this.isLoading = false
                if (response.data.success === true) {
                    this.presentToast('top', response.data.message, 3000, 'success')
                    this.$router.push({ name: 'courses.index' })
                }
                else {
                    this.presentToast('top', response.data.errors[0], 5000, 'danger')
                }
            }).catch(() => {
                this.isLoading = false
                this.presentToast('top', 'Erreur de connexion', 5000, 'danger')
            })
        },
    },
});
</script>
