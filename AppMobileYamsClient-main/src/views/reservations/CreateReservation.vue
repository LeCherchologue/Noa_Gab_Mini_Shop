<template>
    <ActionTemplate>
        <template #page_title>
            <h6>RESERVER UNE COURSE</h6>
        </template>
        <template #content>
            <ion-progress-bar v-if="resIsLoading == true" type="indeterminate"></ion-progress-bar>
            <form v-else @submit.prevent="createLine()">
                <div class="form-group ">
                    <label>Trajet <span class="text-danger">*</span></label>
                    <select v-model="form.trajet_id"  class="form-control" @change="setTrajetDatas()">
                        <option value="" disabled>Selectionner un trajet</option>
                        <option v-for="trajet in trajets" :key="trajet.id" :value="trajet.id">
                            {{ trajet.libelle }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Type de course<span class="text-danger">*</span></label>
                    <select class="form-control" v-model="form.type_course" required>
                        <option value="Aller">Aller</option>
                        <option value="Aller - Retour">Aller - Retour</option>
                        <option value="Retour simple">Retour simple</option>
                    </select>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Depart<span class="text-danger">*</span></label>
                        <input type="date" v-model="form.date_chargement" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Arrivée</label>
                        <input type="date" v-model="form.date_dechargement" class="form-control">
                    </div>
                </div>
                <div class="form-row" v-if="form.trajet_id">
                    <div class="form-group col-md-5">
                        <label>Adresse de chargement<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" v-model="form.adresse_chargement">
                    </div>
                    <div class="col-md-2 text-center">
                        <button v-if="form.adresse_chargement && form.adresse_dechargement"
                            class="btn btn-outline-info rounded-pill" type="button"
                            @click.prevent="echangerAdresses()" required>
                            <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        </button>
                    </div>
                    <div class="form-group col-md-5">
                        <label>Adresse de déchargement<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" v-model="form.adresse_dechargement" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Marchandise à transporter</label>
                    <input type="text" class="form-control" v-model="form.type_marchandise" required>
                </div>

                <!-- <div class="form-group">
                    <label>Moyen de paiement<span class="text-danger">*</span></label>
                    <select  class="form-control" required>
                        <option value="" disabled>Selectionner un moyen de paiement</option>
                        <option value="Carte">Carte</option>
                        <option value="Airtel Money">Airtel Money</option>
                        <option value="À la livraison">À la livraison</option>
                    </select>
                </div> -->
                <button type="submit" class="btn btn-primary btn-block mb-3" :disabled="isLoading">
                    <i class="fa-solid fa-save"></i> Enregistrer
                    <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status"
                    aria-hidden="true"></span>
                </button>

            </form>
        </template>
    </ActionTemplate>
</template>


<script lang="ts">
import $ from "jquery";
import moment from 'moment'
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';

export default defineComponent({
    name: 'CreateReservation',
    inject: ['dialogRef'],
    data() {
        return {
            isLoading: false,
            resIsLoading: true,
            table: 'demandes',
            trajets: [],
            clients: [],
            baseUrl: this.$store.state.api_yams_livraisons,
            form: {
                description: '',
                date_chargement: moment().format('YYYY-MM-DD'),
                date_dechargement: '',
                adresse_chargement: '',
                adresse_dechargement: '',
                type_course: 'Aller - Retour',
                trajet_id: '',
                clientId: this.$store.getters.user.id,
                client_nom: this.$store.getters.user.nom,
                client_prenom: this.$store.getters.user.prenom,
                client_bp: this.$store.getters.user.bp,
                client_adresse: this.$store.getters.user.adresse,
                client_email: this.$store.getters.user.email,
                type_marchandise: ''
            }
        }
    },
    mounted() {
        this.getTrajets()
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
        setTrajetDatas() {
            let trajet = this.trajets.filter(item => item.id === this.form.trajet_id)
            this.form.adresse_chargement = trajet[0].depart
            this.form.adresse_dechargement = trajet[0].arrivee
        },
        echangerAdresses() {
            let varTemp = this.form.adresse_chargement
            this.form.adresse_chargement = this.form.adresse_dechargement
            this.form.adresse_dechargement = varTemp
        },
        getTrajets() {
            this.resIsLoading = true
            this.axios.get(this.baseUrl + '/api/trajets').then((response) => {
                this.trajets = response.data
                this.resIsLoading = false
            }).catch(() => {
                this.resIsLoading = false
                this.presentToast('top', 'Erreur de connexion', 5000, 'danger')
            })
        },
        createLine() {
            this.isLoading = true
            this.axios.post(this.baseUrl + '/api/demandes', this.form).then((response) => {
                this.isLoading = false
                if (response.data.success === true) {
                    this.presentToast('top', response.data.message, 3000, 'success')
                    this.resetForm()
                    this.$router.push({ name: 'home' })
                    window.location.reload();
                    
                }
                
                else {
                    this.presentToast('top', response.data.errors[0], 5000, 'danger')
                }
            }).catch(() => {
                this.isLoading = false
                this.presentToast('top', 'Erreur de connexion', 5000, 'danger')
            })
            
        },
        resetForm() {
            this.form = {
                description: '',
                date_chargement: moment().format('YYYY-MM-DD'),
                date_dechargement: '',
                adresse_chargement: '',
                adresse_dechargement: '',
                type_course: 'Aller - Retour',
                trajet_id: '',
                clientId: this.$store.state.id,
                client_nom: this.$store.state.nom,
                client_prenom: this.$store.state.prenom,
                client_bp: this.$store.state.bp,
                client_adresse: this.$store.state.adresse,
                client_email: this.$store.state.email,
                type_marchandise: ''
            }
        }
    }
})
</script>
