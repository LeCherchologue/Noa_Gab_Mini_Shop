<template>
    <my-template>
        <template #content>
            <ion-toolbar>
                <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar>
                
                
                <div class="d-flex">
                    <div>
                        <ion-title>Chauffeurs ({{ chauffeurs.length }})</ion-title>
                    </div>  
                </div>
            </ion-toolbar>
            
                <list-paginated url="/api/users?poste=Chauffeur">
                <template v-slot:list_content = chauffeurs>
                  <ul class="list-group list-group-flush">
                    <li v-for="chauffeur in chauffeurs.datas" :key="chauffeur.id" @click="openShow(chauffeur)" class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="btn">
                            <div class="d-flex align-items-center row">
                                <div class="col-3">
                                    <img :src="chauffeur.photo" class="w-100 rounded-circle">
                                </div>
                                <div class="col-6">
                                   
                                    <span class="font-weight-bold ">{{ chauffeur.nom }}</span>
                                </div>
                              </div>
                          </div>
                    </li>
                  </ul>
                </template>
                </list-paginated>

              <ion-modal :is-open="show">
                <ion-content>
                    <ion-header>
                        <ion-toolbar color="primary">
                          <ion-buttons slot="end">
                            <ion-button @click="closeShow()" :strong="true">x</ion-button>
                          </ion-buttons>
                        </ion-toolbar>
                      </ion-header>

                      <div id="map" class="cover"></div>
                      
                      <div class="d-flex align-items-center row mt-3 ion-padding">
                        <div class="col-3">
                            <img :src="chauffeur.photo" class="w-50 rounded-circle">
                        </div>
                        <div class="col-6">
                          <span class="font-weight-bold ">Chauffeur principal</span> <br>
                            <small >{{ chauffeur.nom }}</small><br>
                        </div>
                        <div class="col-">
                            <span class="badge badge-primary p-2 rounded-pill">
                              <i class="fa-solid fa-pencil"></i>
                            </span>
                        </div>
                      </div>
                </ion-content>
              </ion-modal>

              <a class="float" @click="openModalChauffeur()">
                <i class="fab fa-add my-float"></i>
                <ion-fab>
                  <ion-fab-button style="margin-top: 800%;">
                  </ion-fab-button>
                </ion-fab>
              </a>

              <ion-modal :is-open="chauffeurModal">
                <ion-header>
                    <ion-toolbar color="primary">
                      <ion-buttons slot="end">
                        <ion-button @click="closeModalChauffeur()" :strong="true">x</ion-button>
                      </ion-buttons>
                    </ion-toolbar>
                  </ion-header>
                <ion-content>
                    <ChauffeurCreate></ChauffeurCreate>
                </ion-content>
              </ion-modal>
        </template>
        
    </my-template>

</template>

<script lang="ts" setup>
import ModalShow from '@/views/chauffeurs/AffectationIndex.vue'
import { onMounted } from 'vue';

import { ref } from 'vue';
import {  modalController } from '@ionic/vue';
const message = ref('This modal example uses the modalController to present and dismiss modals.');

const openModal = async (chauffeurs) => {
    const modal = await modalController.create({
    component: ModalShow,
    componentProps: {
        chauffeurs,
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
import { IonSegment, IonSegmentButton, IonFab, IonFabButton, } from '@ionic/vue';
import { defineComponent, defineAsyncComponent } from 'vue';
import 'leaflet/dist/leaflet.css';
import 'leaflet-control-geocoder';
import L from "leaflet";
import ChauffeurCreate from '@/views/chauffeurs/ChauffeurCreate.vue'

export default defineComponent({
    components: {IonSegment, IonSegmentButton, IonFab, IonFabButton, ChauffeurCreate},
    data() {
        return {
            isLoading: false,
            chauffeurs: [],
            modalPaye: false,
            show: false,
            chauffeur: [],
            chauffeurModal: false
        };
    },
    mounted(){
        this.getChauffeurs()
        
    },
    methods: {
        openModalChauffeur(){
            this.chauffeurModal = true
        },
        closeModalChauffeur(){
            this.chauffeurModal = false
        },
        getPosition(){
            var map = L.map('map').setView([0.3740766849978046, 9.460248606311575], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
        },
        openShow(data){
            this.show = true
            this.chauffeur = data
            this.getPosition()
        },
        closeShow(){
            this.show = false
        },
       getChauffeurs(){
        this.axios('/api/users?poste=Chauffeur').then((response) => {
            this.chauffeurs = response.data
            console.log('chauffeurs =', this.chauffeurs)
        })
       },
       openModal(){
        this.modalPaye = true
       },
       closeModal(){
        this.modalPaye = false
       }
    }
});
</script>

<style>
#map {
    height: 600px;
    width: 100%;
    padding: 0 !important;
}

.cover {
    padding: 0 !important;
}

</style>