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

    
    <div class="container"  v-if="course.chauffeur_principal">
      <div class="bg-white d-flex justify-content-center">
          <img :src="course.chauffeur_principal.photo" class="rounded-circle bg-white p-1 chauffeur-img">
      </div>
      <h3 class="font-weight-bold text-center">{{ course.chauffeur_principal.name }}</h3>

      <a :href="'tel:' + course.chauffeur_principal.telephone1" class="btn btn-primary btn-lg btn-block mb-2">
          <i class="fa-solid fa-phone mr-2"></i> Appeler le chauffeur
      </a>
      <button type="submit" class="btn btn-block btn-sm btn-danger " @click="openAlert()">
        <i class="fa-solid fa-exclamation-circle px-2"></i>Alerter Yam's
      </button>
      
    </div>

    <!-- <div class="mt-2">
      <button type="submit" class="btn btn-block-2 btn-sm btn-danger" @click="openAlert()">
        <i class="fa-solid fa-exclamation-circle px-2"></i>Alerter Yam's
      </button>
    </div> -->

  <ion-modal :is-open="isOpenAlert" style="margin-top: 50%">
    <ion-content>
        <ion-toolbar color="primary">
            <ion-buttons slot="end">
              <ion-button color="light" @click="closeAlert()">fermer</ion-button>
            </ion-buttons>
        </ion-toolbar>
        
        <form @submit.prevent="sendAlert()" class="ion-padding">
            <div class="form-group ion-padding">
                <p class="text-center font-weight-bold">DECRIVEZ VOTRE PROBLEME</p>
            </div>
            <textarea class="form-control" rows="8" v-model="form.message" placeholder="Expliquez nous votre alert"></textarea>
            <button type="submit" class="btn btn-primary mt-4 float-right" >
               Envoyer
            </button>
        </form>
    </ion-content>
</ion-modal>
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

 
  const getPosition = async (plaque) => {
      var map = L.map('map').setView([0.3740766849978046, 9.460248606311575], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            
            //on fait la requete pour recuperer les donnes de la balise
            await axios.get('/api/balises?plaque=' + plaque).then((response) => {
                var latLng = [response.data.lat, response.data.lng]
                var mymarker = L.marker(latLng).addTo(map);
                L.polyline(response.data.tail, { color: 'red' }).addTo(map);

                //on dirrige la carte vers la position
                map.flyTo(latLng, 16, {
                    animate: true,
                    duration: 2
                });

                //on recupere l'adresse de la position
                const geocoder = L.Control.Geocoder.nominatim();
                geocoder.reverse(
                    { lat: response.data.lat, lng: response.data.lng },
                    map.options.crs.scale(map.getZoom()),
                    results => {
                        //On affiche l'adresse dans le popup sinon les coordonnées
                        if (results.length > 0) {
                            mymarker.bindPopup(results[0].name).openPopup();
                        } else {
                            mymarker.bindPopup(latLng).openPopup();
                        }
                    }
                );
            }).catch(() => {
                
               
            })
  }
  var camion: any[]
  const getCourse = () => {
      axios.get('/api/courses/' + course.id).then((response) => {
              getPosition(course.plaque);
              console.log('course',response.data)
              camion = response.data
          }).catch(() => {
          })   
  };

  onMounted(() => {
      getCourse()
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
      form: {
            nom: this.$store.state.user.nom,
            prenom: this.$store.state.user.prenom,
            email: this.$store.state.user.email,
            objet: 'Alerte course ID'+ this.course.id,
            message:''

      }
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
   
  sendAlert(){
    this.$store.state.isLoading = true
    this.axios.post('/api/messages', this.form)
      .then((response) => {
        this.$store.state.isLoading = false
        if (response.data.success === true) {
          this.connectToast('top', 'Alerte envoyé','success')
          this.resetForm()
          this.closeAlert()
         
        } else {
          this.connectToast('top', response.data.errors[0],'danger')
        }
      }).catch((error) => {
        console.log(error)
        this.$store.state.isLoading = false
      
      })
  }
    
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
