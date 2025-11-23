<template>
    <ProgressBar v-if="isLoading === true" mode="indeterminate" style="height: 6px"></ProgressBar>
    <div id="map" class="cover"></div>
    
    <div class="container" v-if="data.chauffeur_principal">
        <div class="bg-white d-flex justify-content-center">
            <img :src="data.camion.photo" class="rounded-circle bg-white p-1 chauffeur-img">
        </div>
        <h3 class="font-weight-bold text-center">{{ data.chauffeur_principal.name }}</h3>
        <h4 class="font-italic text-secondary text-center mb-3"> {{ data.chauffeur_principal.telephone1 }} </h4>
        <a :href="'tel:' + data.chauffeur_principal.telephone1" class="btn btn-primary btn-lg btn-block">
            <i class="fa-solid fa-phone mr-2"></i> Appeler le chauffeur
        </a>
    </div>
  </template>

  <script>
  import 'leaflet/dist/leaflet.css';
  import 'leaflet-control-geocoder';
  import L from "leaflet";
  
  export default {
    inject: ['dialogRef'],
    props: ['data'],
      name: 'ShowMap',
      data() {
          return {
              isLoading: false,
              course: [],
              camion: {}
          }
      },
      mounted() {
        this.getCourse()
        console.log('dta course = ', this.data)
      },
      methods: {
        getCourse(){
            this.axios.get('/api/courses/' + this.data.id).then((response) => {
                this.isLoading = false
                this.course = response.data
                this.camion = response.data.camion

                this.getPosition(this.data.plaque);
                console.log(response.data)
            }).catch(() => {
            })   
        },
          getPosition(plaque) {
              this.isLoading = true
              console.log('plaque = ', plaque)
              //on initialise le container de la carte
              var map = L.map('map').setView([0.3740766849978046, 9.460248606311575], 13);
              L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  maxZoom: 19,
                  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
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
                  this.$toast.add({
                      severity: 'error',
                      summary: 'Probleme de connexion',
                      detail: 'Une erreur s\'est produite lors de la connexion au serveur !',
                      life: 5000
                  });
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
  </style>