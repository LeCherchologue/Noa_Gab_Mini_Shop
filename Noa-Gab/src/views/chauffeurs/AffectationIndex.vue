<template>
  <ion-header>
    <ion-toolbar>
      <ion-buttons slot="end">
        <ion-button @click="confirm" :strong="true">x</ion-button>
      </ion-buttons>
    </ion-toolbar>
  </ion-header>
  <ion-content>
   
    <div id="map" class="cover"></div>
    
    <div class="d-flex align-items-center row mt-3 ion-padding">
      <div class="col-3">
          <img :src="chauffeurs.photo" class="w-50 rounded-circle">
      </div>
      <div class="col-6">
        <span class="font-weight-bold ">Chauffeur principal</span> <br>
          <small >{{ chauffeurs.nom }}</small><br>
      </div>
      <div class="col-">
          <span class="badge badge-primary p-2 rounded-pill">
            <i class="fa-solid fa-pencil"></i>
          </span>
      </div>
    </div>
  </ion-content>
</template>

<script lang="ts" setup>
  import {
    IonContent,
    IonHeader,
    IonTitle,
    IonToolbar,
    IonButtons,
    IonButton,
    modalController,
  } from '@ionic/vue';
  import { defineComponent, ref, onMounted, defineProps } from 'vue';
  import 'leaflet/dist/leaflet.css';
  import 'leaflet-control-geocoder';
  import L from "leaflet";
  import { toastController } from '@ionic/vue';
  import axios from 'axios'
  const name = ref();
  const { chauffeurs } = defineProps(['chauffeurs']);



  console.log('test id = ', chauffeurs)
  const confirm =  () => modalController.dismiss(name.value, 'confirm');
  const errorToast = async (position, mess) => {
      const toast = await toastController.create({
      message: mess,
      duration: 2000,
      position: position,
      color: 'danger'
    });

    await toast.present();
  }
 
  
  const getPosition = () => {
      var map = L.map('map').setView([0.3740766849978046, 9.460248606311575], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
        
  };

  onMounted(() => {
    getPosition()
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
