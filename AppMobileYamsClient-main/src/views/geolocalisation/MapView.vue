<template>
    <!-- <ion-progress-bar v-if="isLoading == true" type="indeterminate"></ion-progress-bar> -->
    <div :key="key" id="map"></div>
  </template>
  
  <script>
  import L from 'leaflet';
  
  export default {
    name: 'MapView',
    props: {
      deviceId: {
        type: Number
      },
      location: {
        type: String
      },
      course:{
        type: Array
      }
    },
    data() {
      return {
        key: 1,
        isLoading: false,
        marker: null,
        positions: [],
        polyline: null,
        map: null,
        syncInterval: null,
        baseUrl: this.$store.state.api_yams_geoloc,
        center: [0.432268, 9.421583],
        zoom: 13,
        popupContent: 'Chargement de l\'adresse en cours'
      };
    },
    mounted() {
      this.initMap();
      if (this.location == 'actual') {
        this.getPosition();
  
        //recharger les positions apres 10sec
        this.syncInterval = setInterval(function () {
          this.getPosition()
        }.bind(this), 10000);
      }
      else if (this.location == 'history') {
        this.getHistory();
      }
  
    },
    beforeUnmount() {
      if (this.location == 'actual') {
        clearInterval(this.syncInterval);
      }
    },
  
    methods: {
      initMap() {
        this.map = L.map('map').setView(this.center, this.zoom);
  
        L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
          maxZoom: 20,
          subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(this.map);
  
        // Rafraîchit la carte pour s'assurer qu'elle se dimensionne correctement
        setTimeout(() => {
          this.map.invalidateSize();
        }, 0);
      },
      async getPosition() {
        this.isLoading = true
        if (this.marker !== null) {
          this.map.removeLayer(this.marker);
        }
  
        //marker pour les balises en ligne
        let markerIconOnline = L.icon({
          iconUrl: this.baseUrl + '/images/marker-bleu.png',
          iconSize: [30, 30],
        });
  
        //marker pour les balises hors lignes
        let markerIconOffline = L.icon({
          iconUrl: this.baseUrl + '/images/marker-noir.png',
          iconSize: [30, 30],
        });
  
        await this.axios.get(this.baseUrl + '/api/appareils?deviceId=' + this.deviceId).then((response) => {
  
          const element = response.data[0]
  
          //on recupere la derniere position de la balise
          const coord = element.latlng[0];
  
          //on affiche le style de markeur en fonction du status
          if (element.status == 'online') {
            //on cree le marker et popup
            this.marker = L.marker([coord.latitude, coord.longitude], { icon: markerIconOnline }).addTo(this.map);
          } else {
            //on cree le marker et popup
            this.marker = L.marker([coord.latitude, coord.longitude], { icon: markerIconOffline }).addTo(this.map);
          }
  
          // Update marker and map center
          this.map.setView([coord.latitude, coord.longitude], this.map.getZoom());
  
          this.marker.bindPopup(element.status).openPopup();
  
          //on recupere les 5 dernieres positions de la balise dispo sur la reponse avec queue
          const points = []
          if (element.queue.length > 0) {
            element.queue.forEach(lineCoord => {
              points.push({
                lat: lineCoord.latitude,
                lng: lineCoord.longitude,
              })
            });
          }
  
          // Update polyline
          this.polyline.setLatLngs(points);
  
          this.isLoading = false
  
        }).catch(() => {
          this.isLoading = false
        })
  
      },
      getHistory() {
        this.isLoading = true
        this.axios.get(this.baseUrl + '/api/positions?deviceId=' + this.deviceId + '&period_from='+this.course.date_chargement+'&period_to='+this.course.date_dechargement).then((response) => {
          this.map.setView([response.data[0].latitude, response.data[0].longitude], this.map.getZoom());
            const points = []
            response.data.forEach(lineCoord => {
              points.push({
                lat: lineCoord.latitude,
                lng: lineCoord.longitude,
              })
  
              L.marker([lineCoord.latitude, lineCoord.longitude]).addTo(this.map);
            });
            L.polyline(points, {color: 'red'}).addTo(this.map );
  
          this.isLoading = false
        }).catch(() => {
          this.isLoading = false
        })
      }
    }
  };
  </script>
  
  <style scoped>
  #map {
    height: 100vh;
    width: 100vw;
  }
  </style>