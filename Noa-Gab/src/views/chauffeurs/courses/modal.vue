<template>
  <ion-header>
    <ion-toolbar color="primary">
  
      <ion-buttons slot="end">
        <ion-button @click="confirm" :strong="true"><span class="badge badge-secondary mx-2">x</span> fermer</ion-button>
      </ion-buttons>
    </ion-toolbar>
  </ion-header>
  <ion-content >
    <div  v-show="historique" id="map" class="cover" style="height: 60%">
    </div>
    <p v-if="historique == false">Aucune donnée disponible</p>

    <div class="container"  v-if="course.chauffeur_principal">
      
      <h3 class="font-weight-bold text-center"> Chauffeur : {{ course.chauffeur_principal.name }}</h3>
      <span class="font-weight-bold">{{ course.adresse_chargement }}</span> <span class="font-italic">({{ course.date_chargement }}) </span>
      <span class="font-weight-bold">{{ course.adresse_dechargement }}</span> <span class="font-italic">({{ course.date_dechargement }})</span>
      <h4 class="font-italic text-secondary text-center mb-3"> {{ course.type_course }} </h4>
      <h4 class="font-italic text-secondary text-center mb-3"> {{ new Intl.NumberFormat('de-DE').format(course.montant) }} fcfa</h4>
      
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
  // import 'leaflet/dist/leaflet.css';
  // import 'leaflet-control-geocoder';
  // import L from "leaflet";
  // import axios from 'axios'
  const name = ref();
  const { course } = defineProps(['course']);

  console.log('test course = ', course)
  const cancel = () => modalController.dismiss(null, 'cancel');
  const confirm = () => modalController.dismiss(name.value, 'confirm');
  // var historique: any
  // const getHistorique = () => {
  //   axios.get(`/api/historique_positions?plaque=` + course.plaque + `&date_debut=` + course.date_chargement + `&date_fin=` + course.date_dechargement).then((response) => {
  
  //     const map = L.map('map').setView([0, 0], 1);

  //         L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  //             maxZoom: 18,
  //             attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  //         }).addTo(map);


  //         var latlngs = []
  //         for (let index = 0; index < response.data.length; index++) {
  //             const element = response.data[index];
  //             latlngs.push({
  //                 lat: element.lat,
  //                 lng: element.lng,
  //             })
  //         }

  //         const polyline = L.polyline(latlngs, { color: 'red' }).addTo(map);

  //         map.fitBounds(polyline.getBounds());
  //         const polylineBounds = polyline.getBounds();
  //         map.panTo(polylineBounds.getCenter());
      
  //     })
  // };

  // onMounted(() => {
  //   getHistorique()
  // });

  
</script>

<script lang="ts">
import 'leaflet/dist/leaflet.css';
import 'leaflet-control-geocoder';
import L from "leaflet";

export default {
  props: {
    course: {
      type: Object,
      default: () => ({})
    }
  },
  inject: ['dialogRef'],
  name: 'ShowMap',
  data() {
      return {
          isLoading: false,
          historique: true
      }
  },
  mounted() {
    this.getHistorique()
    console.log('dta course props = ', this.course)
  },
  methods: {
   
    getHistorique() {


          this.axios.get('/api/historique_positions?plaque=' + this.course.plaque + '&date_debut=' + this.course.date_chargement + '&date_fin=' + this.course.date_dechargement).then((response) => {
            this.isLoading = false
            if (response.data.length == 0) {
                this.historique = false
            }
            else {
                const map = L.map('map').setView([0, 0], 1);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);


                var latlngs = []
                for (let index = 0; index < response.data.length; index++) {
                    const element = response.data[index];
                    latlngs.push({
                        lat: element.lat,
                        lng: element.lng,
                    })
                }

                const polyline = L.polyline(latlngs, { color: 'red' }).addTo(map);

                map.fitBounds(polyline.getBounds());
                const polylineBounds = polyline.getBounds();
                map.panTo(polylineBounds.getCenter());
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
  },
}
</script>

<style>

#map {
  height: 100%;
  width: 100%;
  padding: 0 !important;
}

</style>
