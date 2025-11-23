<template>
    <my-template>
        <template #content>
            <ion-toolbar>
                <!-- <ProgressBar v-if="isLoading === true" mode="indeterminate" style="height: 6px"></ProgressBar> -->
                <!-- <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar> -->
                <!-- <ion-title>Mes courses</ion-title><br> -->
                <ion-segment :value="tab" :scrollable="true">
                    <ion-segment-button value="En cours" @click="tab = 'En cours'">
                        <ion-label>En cours</ion-label>
                    </ion-segment-button>
                    <ion-segment-button value="Terminé" @click="tab = 'Terminé'">
                        <ion-label>Terminés</ion-label>
                    </ion-segment-button>
                </ion-segment>
            </ion-toolbar>
           <ion-content>
               <div class="container">
                  
            </div>
            <list-paginated url="/api/courses?etat=En cours" v-if="tab === 'En cours'">
                <template v-slot:list_content = courses>
                    <ion-list v-for="course in courses.datas" :key="course.id" >
                        <ion-item @click="openModal(course)">
                          <div class="btn">
                            <div class="d-flex align-items-center row">
                                <div class="col-3">
                                    <img src="../../../assets/default_user.png" class="w-100 rounded-circle">
                                </div>
                                <div class="col-6">
                                    <small>Chauffeur principal</small> <br>
                                    <span class="font-weight-bold ">{{ course.nom_chauffeur_principal }}</span><br>
                                    <!-- <small class="font-italic ">{{ course.camion.chauffeur_principal.telephone1 }}</small> -->
                                </div>
                                <div class="col-3">
                                    <lottie-player v-if="course.etat == 'En cours'" autoplay loop mode="normal" style="width: 100%" src="/json/truck_yams.json"></lottie-player>
                                    <i v-else class="fa-solid fa-circle-check"></i>
                                </div>
                              </div>
                          </div>
                          
                        <ion-modal ref="map" :trigger="'opem-map-' + course.id">
                            <ion-content>
                              <ion-toolbar color="light">
                               
                                <ion-buttons slot="end">
                                  <ion-button @click="dismiss('map')">x</ion-button>
                                </ion-buttons>
                              </ion-toolbar>
                              <p>{{ course.id }}</p>
                            </ion-content>
                        </ion-modal>
                        </ion-item>
                    </ion-list>
                </template>
            </list-paginated>

            <list-paginated url="/api/courses?etat=Terminé" v-if="tab === 'Terminé'">
                <template v-slot:list_content = courses>
                    <ion-list v-for="course in courses.datas" :key="course.id" >
                        <ion-item @click="openModal(course)">
                          <div class="btn">
                            <div class="d-flex align-items-center row">
                                <div class="col-3">
                                    <img src="../../../assets/default_user.png" class="w-100 rounded-circle">
                                </div>
                                <div class="col-6">
                                    <small>Chauffeur principal</small> <br>
                                    <span class="font-weight-bold ">{{ course.nom_chauffeur_principal }}</span><br>
                                    <!-- <small class="font-italic ">{{ course.camion.chauffeur_principal.telephone1 }}</small> -->
                                </div>
                                <div class="col-3">
                                    <lottie-player v-if="course.etat == 'En cours'" autoplay loop mode="normal" style="width: 100%" src="/json/truck_yams.json"></lottie-player>
                                    <i v-else class="fa-solid fa-circle-check"></i>
                                </div>
                              </div>
                          </div>
                          
                        <ion-modal ref="map" :trigger="'opem-map-' + course.id">
                            <ion-content>
                              <ion-toolbar color="light">
                               
                                <ion-buttons slot="end">
                                  <ion-button @click="dismiss('map')">x</ion-button>
                                </ion-buttons>
                              </ion-toolbar>
                              <p>{{ course.id }}</p>
                            </ion-content>
                        </ion-modal>
                        </ion-item>
                    </ion-list>
                </template>
            </list-paginated>
           </ion-content>
        </template>
        
    </my-template>
</template>
<script lang="ts" setup>
import Modal from '@/views/courses/modal.vue'
import ModalShow from '@/views/courses/modalShow.vue'
import { ref } from 'vue';
import {  modalController } from '@ionic/vue';
const message = ref('This modal example uses the modalController to present and dismiss modals.');

const openModal = async (course) => {
    if (course.etat == 'En cours') {
        const modal = await modalController.create({
        component: ModalShow,
        componentProps: {
            course
        },
        });

        modal.present();

        const { data, role } = await modal.onWillDismiss();

        if (role === 'confirm') {
        message.value = `Hello, ${data}!`;
        }
    }
    else{
        const modal = await modalController.create({
        component: Modal,
        componentProps: {
            course
        },
        });

        modal.present();

        const { data, role } = await modal.onWillDismiss();

        if (role === 'confirm') {
        message.value = `Hello, ${data}!`;
        }
    }
};
</script>



<script lang="ts">
import moment from 'moment'
import { IonSegment, IonSegmentButton, IonFab, IonFabButton, } from '@ionic/vue';
import { defineComponent, defineAsyncComponent } from 'vue';
import { ref } from 'vue';
import { toastController } from '@ionic/vue';
import { swapVertical } from 'ionicons/icons';

export default defineComponent({
    components: {IonSegment, IonSegmentButton, IonFab, IonFabButton, toastController},
    data() {
        return {
            isLoading: true,
            first: 0,
            rows: 8,
            attente: false,
            tab: 'En cours',
            swapVertical,
            coursesFiltered: [],
            coursesDemandes: [],
            key: 1,
            open: false,
            presentingElement: undefined,
            reservation: false,
            trajets: [],
            camions: [],
            clients: [],
            form: {
            type_course: '',
            date_chargement: '',
            date_dechargement: '',
            adresse_chargement: '',
            adresse_dechargement: '',
            trajet_id: 0,
            client_id: this.$store.state.user.id,
            description: '',
            etat: 'demande'
            },
        };
    },
    
    mounted(){
      this.getCourses()
      console.log('state = ', this.$store.state.mobileNotifications)
      this.form.date_chargement = moment().format('YYYY-MM-DD');
      this.getCamions()
      this.getTrajets()
      this.getClients()
    },
    methods: {
      
        goMap(course, camion){
            // if (course.etat == 'En cours') {
            //     this.openMap(camion)
            // }
            // else{
            //     this.openMapTerminer(course)
            // }
        
            
        },
       
        FilterCourses (datas) {
           return datas.filter(item => item.etat == this.tab)
        },
        
        getCourses(){
            this.axios.get('/api/courses').then((response) => {
                console.log('courses = ',response.data)
            })
        },
        openReservation(){
            this.reservation = true
        },
        closeReservation(){
            this.reservation = false
        },
        async connectToast(position, mess) {
      const toast = await toastController.create({
        message: mess,
        duration: 2000,
        position: position,
        color: 'success'
      });

      await toast.present();
    },
    async presentToast(position, mess) {
      const toast = await toastController.create({
        message: mess,
        duration: 2000,
        position: position,
        color: 'danger'
      });

      await toast.present();
    },
        setTrajetDatas(value) {
        if (value) {
            let trajet = this.trajets.filter(item => item.id === value)
            this.form.type_camion = trajet[0].type_camion
            
            this.form.ration = trajet[0].ration
            this.form.adresse_chargement = trajet[0].depart
            this.form.adresse_dechargement = trajet[0].arrivee
        }
        },
        echangerAdresses() {
        let varTemp = this.form.adresse_chargement
        this.form.adresse_chargement = this.form.adresse_dechargement
        this.form.adresse_dechargement = varTemp
        },
        getClients() {
        
        this.axios.get('/api/users?type_user=client').then((response) => {
            this.clients = response.data
            this.$store.state.isLoading = false
        }).catch(error => {
            this.errors = error.response.data.errors
            this.key++
            this.showErrors = true
            this.$store.state.isLoading = false
            this.$toast.error('Une erreur s\'est produite lors de la récupération !')
        })
        },
        getTrajets() {
    
        this.axios.get('/api/trajets').then((response) => {
            this.trajets = response.data
            this.$store.state.isLoading = false
        }).catch(error => {
            this.errors = error.response.data.errors
            this.key++
            this.showErrors = true
            this.$store.state.isLoading = false
            this.$toast.error('Une erreur s\'est produite lors de la récupération !')
        })
        },
    
        getCamions() {
        this.$store.state.isLoading = true
        this.axios.get('/api/camions?statut=Disponible').then((response) => {
            this.camions = response.data
            this.$store.state.isLoading = false
        }).catch((error) => {
            this.errors = error.response.data
            this.key++
            this.$store.state.isLoading = false
        
        })
        },
        createLine() {
        this.$store.state.isLoading = true
        this.axios.post('/api/course_demandes', this.form)
            .then((response) => {
            this.$store.state.isLoading = false
            if (response.data.success === true) {
                this.connectToast('top', response.data.message)
                this.resetForm()
                this.$router.push({ name: 'accueil' })
            
            } else {
                this.presentToast('top', response.data.errors[0])
            }
            }).catch((error) => {
            console.log(error)
            this.$store.state.isLoading = false
            
            })
        },
        resetForm() {
        this.step = 1,
            this.form = {
            type_course: '',
            date_chargement: '',
            date_dechargement: '',
            adresse_chargement: '',
            adresse_dechargement: '',
            trajet_id: 0,
            client_id: this.$store.state.user.id,
            description: '',
            }
        },
        
    }
});
</script>


<!-- <template>
    <ion-page>
        <ion-content>
            <TopBar></TopBar>
            <ProgressBar v-if="isLoading === true" mode="indeterminate" style="height: 6px"></ProgressBar>
            <div class="container">
                <h5 class="mb-3">Mes courses</h5>
                <ion-segment value="en_cours">
                    <ion-segment-button value="en_cours">
                        <ion-label>En cours</ion-label>
                    </ion-segment-button>
                    <ion-segment-button value="termine">
                        <ion-label>Terminés</ion-label>
                    </ion-segment-button>
                </ion-segment>
            </div>
        </ion-content>
        
        <ion-content>
            <bottom-bar></bottom-bar>
        </ion-content>
    </ion-page>
</template>
  
<script lang="ts">
import { IonSegment, IonSegmentButton } from '@ionic/vue';
import { defineComponent } from 'vue';

export default defineComponent({
    components: {IonSegment, IonSegmentButton},
    data() {
        return {
            isLoading: true
        };
    }
});
</script> -->
