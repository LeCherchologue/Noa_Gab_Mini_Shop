<template>
  <ion-header >
    <ion-toolbar color="primary">
      <ion-buttons slot="end">
        <ion-button @click="confirm" :strong="true"><span class="badge badge-secondary mx-2">x</span>fermer</ion-button>
      </ion-buttons>
    </ion-toolbar>
  </ion-header>
  <ion-content>
    <div id="map" class="cover" style="height: 60%"></div>

    
  </ion-content>
</template>

<script lang="ts" setup>
  import {
    IonContent,
    IonHeader,
    IonToolbar,
    IonButtons,
    IonButton,
    modalController,
  } from '@ionic/vue';
  import { defineComponent, ref, onMounted, defineProps } from 'vue';
  import 'leaflet/dist/leaflet.css';
  import 'leaflet-control-geocoder';
  import L from "leaflet";
  import axios from 'axios'
  const name = ref();
  const { course } = defineProps(['course']);

  console.log('test id = ', course)
  const cancel = () => modalController.dismiss(null, 'cancel');
  const confirm = () => modalController.dismiss(name.value, 'confirm');

 
  const getPosition = async () => {
      var map = L.map('map').setView([0.3740766849978046, 9.460248606311575], 13);
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      }).addTo(map); 
  }
  onMounted(() => {
        getPosition()
  });

 

  
</script>


<script  lang="ts">
import { toastController } from '@ionic/vue';
export default {
components: [toastController],
props:['course'],
  data() {
    return {
      isLoading: true,
      isOpenAlert: false,
      
    };
  },




  methods: {
    openAlert(){
      this.isOpenAlert = true
    },
    closeAlert(){
      this.isOpenAlert = false
    },
    resetForm(){
      this.form = {
            nom: this.$store.state.user.nom,
            prenom: this.$store.state.user.prenom,
            email: this.$store.state.user.email,
            objet: 'Alerte course ID'+ this.course.id,
            message:''

      }
    },

    async connectToast(position, mess, severity) {
    const toast = await toastController.create({
      message: mess,
      duration: 2000,
      position: position,
      color: severity
    });

    await toast.present();
  },
   
    
  }
};
</script>

<style>

#map {
      height: 100%;
      width: 100%;
      padding: 0 !important;
  }
  .cover {
      padding: 0 !important;
  }
  .chauffeur-img {
    width: 100px;
    margin-top: -35px;
    z-index: 100000;
}

</style>




<!-- <template>
    <ion-header>
      <ion-toolbar>
        <ion-buttons slot="end">
          <ion-button @click="confirm" :strong="true">x</ion-button>
        </ion-buttons>
      </ion-toolbar>
    </ion-header>
    <ion-content>
      <h3 class="text-center font-weight-bold">{{ plaque }}</h3>
      <div id="map" class="cover" style="height: 60%"></div>
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
    const { camion } = defineProps(['camion']);
    var chauffeur_principal: any
    if (camion.chauffeur_principal !== undefined) {
      chauffeur_principal = camion.chauffeur_principal.name
    }
    const plaque = camion.plaque
    const photo = camion.photo
    console.log('test id = ', camion)
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
            
              axios.get('/api/balises?plaque=' + camion.plaque).then((response) => {
                  this.isLoading = false
                  var latLng = [response.data.lat, response.data.lng]
                  var mymarker = L.marker(latLng).addTo(map);
                  L.polyline(response.data.tail, { color: 'red' }).addTo(map);
  
                 
                  map.flyTo(latLng, 16, {
                      animate: true,
                      duration: 2
                  });
  
                
                  const geocoder = L.Control.Geocoder.nominatim();
                  geocoder.reverse(
                      { lat: response.data.lat, lng: response.data.lng },
                      map.options.crs.scale(map.getZoom()),
                      results => {
                          
                          if (results.length > 0) {
                              mymarker.bindPopup(results[0].name).openPopup();
                          } else {
                              mymarker.bindPopup(latLng).openPopup();
                          }
                      }
                  );
              }).catch(() => {
                  
                  errorToast('top', 'Une erreur s\'est produite lors de la connexion au serveur !')
              })
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

</style> -->
