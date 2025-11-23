<template>
  <my-template>
     <template #content>
    
      <div class="container py-3 text-dark">
        <div v-if="isLoading">
          <div class="overlay" >
            <div class="overlay__inner">
              <div class="overlay__content">
                <span class="spinner"></span>
              </div>
            </div>
          </div>
        </div>
        <img src="/src/assets/IMG-Proprio2.png" class="w-100 rounded mb-3">
        <!-- partie propriétaire -->
        <div v-if="this.$store.getters.user.type == 'proprietaire'">
          <div class="d-flex justify-content-center row mb-3">
            <div class="col-md-3 col-6">
              
                <div class="card" style="height: 5rem;background-color: rgb(216, 216, 216);">
                  <router-link to="/camions" class="card-body p-2" >
                    <span>Mes camions </span>
                    <p class="text-center mt-3">{{ camions.length }}</p>
                  </router-link>
                </div>
            </div>
            

            <div class="col-md-3 col-6">

              <div class="card" style="height: 5rem;background-color: rgb(216, 216, 216);">
                <router-link to="/courses" class="card-body p-2" >
                  <span>Courses</span>
                  <p class="text-center mt-3">{{ courses.length }}</p>
                </router-link>
              </div>
            </div>

            <!-- <div class="col-md-3 col-6 mt-4">
              <div class="card" style="height: 5rem;background-color: rgb(216, 216, 216);">
                <div class="card-body p-2" >
                  <span>Mes chauffeurs </span>
                  <p class="text-center mt-3"></p>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-6 mt-4">
              <div class="card" style="height: 5rem;background-color: rgb(216, 216, 216);">
                <div class="card-body p-2" >
                  <span>Mes gains</span>
                  <p class="text-center mt-3"></p>
                </div>
              </div>
            </div> -->

            <div class="col-md-3 col-6 mt-3">
              <div class="card" style="height: 5rem">
                <div class="card-body p-2" >
                  <span style="margin-left: 43%;"><i class="fa-solid fa-envelope"></i></span>
                  <p class="text-center mt-3">Messages</p>
                </div>
              </div>
             
            </div>

            <div class="col-md-3 col-6 mt-3">
              <div class="card" style="height: 5rem">
                <div class="card-body p-2" >
                  <span style="margin-left: 43%;"><i class="fa-solid fa-list"></i></span>
                  <p class="text-center mt-3">Annonces</p>
                </div>
              </div>
            </div>
          </div>
          <div @click="openCalendar()" class="btn btn-lg btn-block" style="background-color: rgb(216, 216, 216);">
            <i class="fa-solid fa-calendar"></i> Calendrier
          </div>
        </div>
        <!-- partie chauffeur -->
        <div v-if="this.$store.getters.user.type == 'employe' && this.$store.getters.user.poste == 'Chauffeur'">
          <div>
            <div class="d-flex justify-content-center row mb-3">
              <div class="col-md-3 col-6 mt-3">
                <div class="card" style="height: 5rem;background-color: rgb(216, 216, 216);">
                  <div class="card-body p-2" >
                    <span>Courses </span>
                    <p class="text-center mt-3">{{ courses.length }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md-3 col-6 mt-3">
                <div class="card" style="height: 5rem;background-color: rgb(216, 216, 216);">
                  <div class="card-body p-2" >
                    <span>Mes gains</span>
                    <p class="text-center mt-3"></p>
                  </div>
                </div>
              </div>
            
            </div>
          </div>
  
          <div class="btn btn-lg btn-block" style="background-color: rgb(216, 216, 216);" @click="openCalendar()">
            <i class="fa-solid fa-calendar"></i> Calendrier
          </div>
          <div class="btn btn-lg btn-block" style="background-color: rgb(216, 216, 216);">
            <i class="fa-solid fa-add"></i> Déclarer un panne 
          </div>
        </div>
        <ion-modal :is-open="calendrier">
          <ion-header>
            <ion-toolbar color="primary">
              <ion-title>CALENDRIER</ion-title>
              <ion-buttons slot="end">
                <ion-button @click="closeCalendar()" :strong="true">x</ion-button>
              </ion-buttons>
            </ion-toolbar>
          </ion-header>
          <ion-content class="ion-padding">
              <div>
                  <div class="header-contentys pt-3 d-flex align-items-center">
                  </div>
          
                  <div class="body-contentys ">
                     
                      <FullCalendar :options='calendarOptions'>
                          <template v-slot:eventContent='arg'>
                              <small href="#" class="btn text-wrap text-white" @click.prevent="showEvent(arg.event.extendedProps)">{{ arg.event.title
                              }}</small>
                          </template>
                      </FullCalendar>
                  </div>
              </div>
              <div>
      
              </div>
          </ion-content>
        </ion-modal>
      </div>
    </template>
  </my-template>


  
</template>

<!-- <script lang="ts" setup>
import Modal from '@/views/layouts/Calendrier.vue'
import { ref } from 'vue';
import {  modalController } from '@ionic/vue';
const message = ref('This modal example uses the modalController to present and dismiss modals.');

const openModal = async () => {
  const modal = await modalController.create({
  component: Modal,
  });

  modal.present();

  const { data, role } = await modal.onWillDismiss();

  if (role === 'confirm') {
  message.value = `Hello, ${data}!`;
  }
};
</script> -->

<style>
ion-card {
  height: 80px;
  width: 145px;
}
</style>

<script  lang="ts">
import Calendrier from './layouts/Calendrier.vue';
import moment from 'moment'
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import bootstrapPlugin from '@fullcalendar/bootstrap';
export default {
  components: { FullCalendar },
    data() {
      return {
        isLoading: true,
        courses: [],
        calendrier: false,
        demandes: [],
        camions: [],
        courseenCours: [],
        courseProgramme: [],
        CA: [],
        depenses: [],
        recettes: [],
        lastID: 1,
        calendarOptions: {
            plugins: [dayGridPlugin, bootstrapPlugin],
            themeSystem: 'bootstrap',
            initialView: 'dayGridMonth',
            events: [],
            locale: 'fr',
            height: '500px',
            datesSet: this.handleMonthChange,
            eventClassNames: 'custom-event-card',
            headerToolbar:{
                left: 'prev,next',
                center: 'title',
                right: 'dayGridDay,dayGridMonth'
            }
        },
        moisPlay: null
      };
    },

    mounted(){
      this.getCourses()
      this.getCamions()
      this.getCoursesenCours()
      this.getCourseProgrammer()
      this.getDemandes()
      this.getCA()
      this.getCA_D()
      this.getCA_R()
      this.refreshDatas(moment().format('YYYY-MM'))
    },

    methods: {
      openCalendar(){
        this.calendrier = true
      },
      closeCalendar(){
        this.calendrier = false
      },
      getDemandes(){
        this.axios.get('/api/course_demandes?statut=En attente').then((response) => {
            this.isLoading = false
            this.demandes = response.data
            
        }).catch(() => {
        })  
      },
      getCourses(){
        this.isLoading = true
        this.axios.get('/api/courses').then((response) => {
          this.courses = response.data
          this.isLoading = false
            
        }).catch(() => {
        })   
      },

      demerrageCourse(id){
        this.axios.get('/api/courses/' + id + '/demarrer').then((response) => {
            this.isLoading = false
        }).catch(() => {
        })   
      },

      confirmDechargement(id) {
        this.isLoading = true
        this.axios.post('/api/courses/' + id + '/confirm').then((response) => {
            this.isLoading = false
            if (response.data.success === true) {
                this.$toast.add({
                    severity: 'success',
                    detail: response.data.message,
                    life: 3000
                });
            }
            else {
                response.data.errors.forEach(element => {
                    this.$toast.add({
                        severity: 'warn',
                        summary: 'Oups !',
                        detail: element,
                        life: 7000
                    });
                });
            }
        }).catch(() => {
            this.isLoading = false
            this.$toast.add({
                severity: 'error',
                summary: 'Probleme de connexion',
                detail: 'Une erreur s\'est produite lors de la connexion au serveur !',
                life: 5000
            });
        })
      },

      getCoursesenCours(){
        this.axios.get('/api/courses?etat=En%20cours').then((response) => {
            this.isLoading = false
            this.courseenCours = response.data
        }).catch(() => {
        })   
      },

      getCourseProgrammer(){
        this.axios.get('/api/courses?etat=Programmé').then((response) => {
            this.isLoading = false
            this.courseProgramme = response.data
        }).catch(() => {
        })   
      },


      getCamions(){
        this.axios.get('/api/camions').then((response) => {
            this.isLoading = false
            this.camions = response.data
            console.log(response.data)
        }).catch(() => {
        })   
      },
      
      getCA(){
        this.axios.get('/api/proprietaires/CA').then((response) => {
            this.isLoading = false
            console.log(response.data)
        }).catch(() => {
        })   
      },
      getCA_D(){
        this.axios.get('/api/proprietaires/CA_d').then((response) => {
            this.isLoading = false
            console.log(response.data)
        }).catch(() => {
        })   
      },
      getCA_R(){
        this.axios.get('/api/proprietaires/CA_r').then((response) => {
            this.isLoading = false
            console.log(response.data)
        }).catch(() => {
        })   
      },
      handleMonthChange(payload) {
            const newDate = payload.view.currentStart
            const mois = newDate.getMonth() + 1
            const annee = newDate.getFullYear()
            this.refreshDatas(moment().format(annee + '-' + mois))
        },
        async refreshDatas(YYYYmm) {
            await this.getCourses(YYYYmm)
        },
        getCourses(period) {
            this.isLoading = true
            this.axios.get('/api/courses?req_period=' + period).then((response) => {
                response.data.forEach(element => {
                    this.calendarOptions.events.push({
                        title: 'Départ course ' + element.plaque + ' ' + element.adresse_chargement + ' - ' + element.adresse_dechargement,
                        date: element.date_chargement,
                        color: 'blue',
                        extendedProps: {
                            id: element.id,
                            table: 'courses',
                            data: element
                        },
                        id: this.lastID++
                    })
                    if (element.date_dechargement) {
                        this.calendarOptions.events.push({
                            title: 'Arrivée course ' + element.plaque + ' ' + element.adresse_chargement + ' - ' + element.adresse_dechargement,
                            date: element.date_dechargement,
                            color: 'green',
                            extendedProps: {
                                id: element.id,
                                table: 'courses',
                                data: element
                            },
                            id: this.lastID++
                        })
                    }
                });
                this.isLoading = false
            }).catch(() => {
                this.isLoading = false
                this.$toast.add({
                    severity: 'error',
                    summary: 'Probleme de connexion',
                    detail: 'Une erreur s\'est produite lors de la connexion au serveur !',
                    life: 5000
                });
            })
        },
    }
  };
</script>

