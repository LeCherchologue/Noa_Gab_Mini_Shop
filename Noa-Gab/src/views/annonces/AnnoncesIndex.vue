<template>
    <my-template>
      <template v-slot:content>
        <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar>
        <div class="container">
          <h5 class="mb-3">Annonces</h5>
          <!-- <ion-segment value="disponible" :scrollable="true">
            <ion-segment-button value="disponible">
                <ion-label>Disponible</ion-label>
            </ion-segment-button>
            <ion-segment-button value="en_traitement">
                <ion-label>En traitement</ion-label>
            </ion-segment-button>
          </ion-segment> -->
          <list-paginated url="/api/annonces">
            <template v-slot:list_content = annonces>
              <ul v-for="annonce in annonces.datas" :key="annonce.id" class="list-group list-group-flush" @click="openModal(annonce)">
                <li  class="list-group-item d-flex justify-content-between align-items-center">
                  <div>
                      <span class="font-weight-bold ">#ID{{ annonce.id }} {{ annonce.date_chargement }}</span><br>
                      <h6>{{ annonce.adresse_chargement }} - {{ annonce.adresse_dechargement }}</h6>
                      <small class="font-italic ">{{ annonce.type_marchandise }}</small>
                  </div>
                  <div>
                    <button class="badge badge-primary p-2 rounded-pill" @click="postAnnonces(annonce.id)">
                        Postuler
                    </button>
                    <button class="badge badge-secondary p-2 rounded-pill mx-2" @click="annuleAnnonce(annonce.id)">
                      Annuler
                  </button>
                  </div>
                </li>
              </ul>
            </template>
          </list-paginated>
          
          <!-- <div>
            <ul v-for="annonce in annonces" :key="annonce.id" class="list-group list-group-flush" @click="openModal(annonce)">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <span class="font-weight-bold ">#ID{{ annonce.id }} {{ annonce.date_chargement }}</span><br>
                    <h6>{{ annonce.adresse_chargement }} - {{ annonce.adresse_dechargement }}</h6>
                    <small class="font-italic ">{{ annonce.type_marchandise }}</small>
                </div>
                <div>
                  <button class="badge badge-primary p-2 rounded-pill" @click="postAnnonces(annonce.id)">
                      Postuler
                  </button>
                  <button class="badge badge-secondary p-2 rounded-pill mx-2" @click="annuleAnnonce(annonce.id)">
                    Annuler
                </button>
                </div>
              </li>
            </ul>
          </div> -->
        </div>
  
      </template>
    </my-template>
    
    <!-- <TemplateCommerce v-if="this.$store.getters.user.type == 'employe' && this.$store.getters.user.poste !== 'Chauffeur'">
      <template v-slot:content>
        <ProgressBar v-if="isLoading === true" mode="indeterminate" style="height: 6px"></ProgressBar>
        <div class="container">
          <h5 class="mb-3">Annonces</h5>
          <ion-segment value="disponible" :scrollable="true">
            <ion-segment-button value="disponible">
                <ion-label>Disponible</ion-label>
            </ion-segment-button>
            <ion-segment-button value="en_traitement">
                <ion-label>En traitement</ion-label>
            </ion-segment-button>
          </ion-segment>
          <list-paginated url="/api/annonces">
            <template v-slot:list_content = annonces>
              <ion-list v-for="annonce in annonces" :key="annonce.id"
              class="list-group-item d-flex justify-content-between align-items-center">
                <ion-item>
                  <small class="font-weight-bold mr-3">#ID{{ annonce.id }} {{ annonce.date_chargement }}</small>
                  <br>
                  <p>Adresse chargement: {{ annonce.adresse_chargement }}</p>
                  <p>Adresse déchargement: {{ annonce.adresse_dechargement }}</p>
                  
                  <span> {{ annonce.type_marchandise }} </span><br><br>

                  <button class="btn btn-primary" @click="postAnnonces(annonce.id)"
                  >Postuler </button>
                <button class="btn btn-secondary mx-2" @click="annuleAnnonce(annonce.id)"
                  >Annuler </button>
                </ion-item>
            </ion-list>
            </template>
          </list-paginated>
        </div>
  
      </template>
    </TemplateCommerce> -->
  </template>

  <script lang="ts" setup>
import Modal from '@/views/annonces/ModalAnnonce.vue'

import { ref } from 'vue';
import {  modalController } from '@ionic/vue';
const message = ref('This modal example uses the modalController to present and dismiss modals.');

const openModal = async (annonces) => {
  const modal = await modalController.create({
  component: Modal,
  componentProps: {
      annonces
  },
  });

  modal.present();

  const { data, role } = await modal.onWillDismiss();

  if (role === 'confirm') {
  message.value = `Hello, ${data}!`;
  }
  
};
</script>
  
  <script lang="ts">
  import { IonLabel, IonSegment, IonSegmentButton } from '@ionic/vue';
  import { defineComponent } from 'vue';
  
  export default defineComponent({
    components: { IonLabel, IonSegment, IonSegmentButton },
    data() {
      return {
       
        isLoading: false,
        form: {
        annonce_id: '',
        user_id: this.$store.getters.user.id,
        annonces: []
      },
      };
    },
    mounted(){
      this.getAnnonces()
    },
   
    methods: {
      getAnnonces() {
      this.axios.get('/api/annonces').then((response) => {
        console.log(response.data)
        this.annonces = response.data
      })
    },
      postAnnonces(id) {
      this.form.annonce_id = id
      this.axios.post('/api/annonce_user', this.form).then((response) => {

        console.log('mess = ', response.data.success)
        if (response.data.success === true) {
          this.$toast.add({
            severity: 'success',
            detail: response.data.message,
            life: 3000
          });
        }
        else {
          this.$toast.add({
            severity: 'error',
            summary: 'Erreur d\'enregistrement',
            detail: response.data.errors[0],
            life: 5000
          });
        }
        this.isLoading = false
      }).catch(() => {

        this.isLoading = false

      })
    },
    annuleAnnonce(id) {
      this.form.annonce_id = id
      this.isLoading = true
      this.axios.post('/api/annonce_user/annuler', this.form).then((response) => {

        console.log('annuler = ', response.data)
        if (response.data.success === true) {
          this.$toast.add({
            severity: 'success',
            detail: response.data.message,
            life: 3000
          });
        }
        else {
          this.$toast.add({
            severity: 'error',
            summary: 'Erreur d\'enregistrement',
            detail: response.data.errors[0],
            life: 5000
          });
        }
        this.isLoading = false
      }).catch(() => {
        this.isLoading = false

      })
    },
    }
  });
  </script>
  