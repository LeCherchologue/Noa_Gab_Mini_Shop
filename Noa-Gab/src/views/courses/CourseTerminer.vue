<template>
    <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar>
    <div v-show="historique" id="map" class="cover"></div>
    <p v-if="historique == false">Aucune donnée disponible</p>
    <!-- <div class="container"  v-if="data.chauffeur_principal">
      
        <h3 class="font-weight-bold text-center"> Chauffeur : {{ data.chauffeur_principal.name }}</h3>
        <span class="font-weight-bold">{{ data.adresse_chargement }}</span> <span class="font-italic">({{ data.date_chargement }}) </span>
        <span class="font-weight-bold">{{ data.adresse_dechargement }}</span> <span class="font-italic">({{ data.date_dechargement }})</span>
        <h4 class="font-italic text-secondary text-center mb-3"> {{ data.type_course }} </h4>
        <h4 class="font-italic text-secondary text-center mb-3"> {{ new Intl.NumberFormat('de-DE').format(data.montant) }} fcfa</h4>
    </div> -->

    <div class="container">
        <!-- <h4 class="font-weight-bold">Facture #{{ factures.id }}</h4> -->
              <hr class=" mb-3">
              <div class=" d-flex"   v-if="data.chauffeur_principal">
                  <div class="col-md-5" >
                      <strong>Chauffeur : </strong>
                  </div>
                  <div class="col-md-7">
                    {{ data.chauffeur_principal.name }}
                  </div>
              </div>
              <div class=" d-flex">
                  <div class="col-md-5">
                      <strong>Adresse de chargement: </strong>
                  </div>
                  <div class="col-md-7">
                    {{ data.adresse_chargement }}
                  </div>
              </div>
              <div class=" d-flex">
                  <div class="col-md-5">
                      <strong>Date de chargement: </strong>
                  </div>
                  <div class="col-md-7">
                    {{ dates(data.date_chargement) }}
                  </div>
              </div>
              <div class=" d-flex">
                <div class="col-md-5">
                    <strong>Adresse de déchargement: </strong>
                </div>
                <div class="col-md-7">
                  {{ data.adresse_dechargement }}
                </div>
              </div>
              <div class=" d-flex">
                <div class="col-md-5">
                    <strong>Date de déchargement: </strong>
                </div>
                <div class="col-md-7">
                  {{ dates(data.date_dechargement) }}
                </div>
              </div>
              <div class=" d-flex">
                <div class="col-md-5">
                    <strong>Type de course: </strong>
                </div>
                <div class="col-md-7">
                  {{ data.type_course }}
                </div>
              </div>
              <div class=" d-flex">
                <div class="col-md-5">
                    <strong>Montant: </strong>
                </div>
                <div class="col-md-7">
                  {{ new Intl.NumberFormat('de-DE').format(data.montant) }} FCFA
                </div>
              </div>
      </div>
  </template>

  <script>
  import 'leaflet/dist/leaflet.css';
  import 'leaflet-control-geocoder';
  import L from "leaflet";
  import moment from 'moment';
  
  export default {
    inject: ['dialogRef'],
    props: ['data'],
      name: 'ShowMap',
      data() {
          return {
              isLoading: false,
              course: [],
              historique: true
          }
      },
      mounted() {
        this.getHistorique()
        console.log('dta course terminé = ', this.data)
      },
      methods: {
        dates(data){
            const date = moment(data).format('DD-MM-YYYY');
            return date
        },
        getHistorique() {

            this.isLoading = true
              this.axios.get('/api/historique_positions?plaque=' + this.data.camion.plaque + '&date_debut=' + this.data.date_chargement + '&date_fin=' + this.data.date_dechargement).then((response) => {
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