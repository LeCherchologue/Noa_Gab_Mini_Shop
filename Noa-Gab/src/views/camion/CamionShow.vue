<template>
    <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar>
    <div id="mapRef" class="cover" style="height: 60%"></div>
    <div class="container mt-4" >
        <div class=" d-flex">
            <div class="col-md-5" >
                <strong>Chauffeur: </strong>
            </div>
            <div class="col-md-7">
                {{ data.chauffeur_principal}}
            </div>
        </div>
        <div class=" d-flex">
            <div class="col-md-5" >
                <strong>Plaque: </strong>
            </div>
            <div class="col-md-7">
                {{ data.plaque }}
            </div>
        </div>
        <div class=" d-flex">
            <div class="col-md-5" >
                <strong>Détails: </strong>
            </div>
            <div class="col-md-7">
                {{ data.identite }}
            </div>
        </div>
       
    </div>
  </template>

  <script>
  import 'leaflet/dist/leaflet.css';
  import 'leaflet-control-geocoder';
  import L from "leaflet";
  import { toastController } from '@ionic/vue';
  export default {
      inject: ['dialogRef'],
      props: ['data'],
      name: 'ShowMap',
      data() {
          return {
            isLoading: false,
            camion: [],
            matricule: '',
            modele: '',
            kilometrage: 0,
            carburant: '',

        
          }
      },
      mounted(){
        this.getCamions()
        this.getPosition(this.data.plaque)
        console.log('datas = ', this.data)
      },
     
      methods: {
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
        goCourses(){
            this.$router.push({ name: 'camion.courses', params: { id: this.data.id} })
        },
        getCamions(){
            this.axios.get('/api/camions/' + this.data.id).then((response) => {
                this.matricule = response.data.plaque
                this.carburant = response.data.type_carburant
                this.kilometrage = response.data.kilometrage
                this.modele = response.data.modele.libelle
                this.isLoading = false
                console.log('show camion', this.camion)
            }).catch(() => {
            })   
        },
          getPosition(plaque) {
              this.isLoading = true
              
              //on initialise le container de la carte
              var map = L.map('mapRef').setView([0.3740766849978046, 9.460248606311575], 13);
              L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  maxZoom: 19,
                  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
              }).addTo(map);
              
              //on fait la requete pour recuperer les donnes de la balise
              this.axios.get('/api/balises?plaque=' + plaque).then((response) => {
                  this.isLoading = false
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
                  this.isLoading = false
                  
                  this.presentToast('top', 'Une erreur s\'est produite lors de la connexion au serveur !')
              })
          }
      },
  }
  </script>
  <style scoped>
  #map {
      height: 400px;
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
  ion-modal {

    --border-radius: 20px;
    
  }
  </style>