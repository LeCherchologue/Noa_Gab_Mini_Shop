<template>
    <my-template>
        <template #content>
           
           <ion-content class="ion-padding">
            <ProgressBar v-if="isLoading === true" mode="indeterminate" style="height: 6px"></ProgressBar>
            <ion-title class="mb-3">Réserver un camion</ion-title>
            <div class="container">
              <form @submit.prevent="createLine()">
                  <div class="form-group ">
                      <label>Type de course<span class="text-danger">*</span></label>
                      <select name="type" class="form-control" v-model="form.type_course">
                        <option value="Aller - Retour">Aller - Retour</option>
                        <option value="Aller">Aller</option>
                        <option value="Retour">Retour</option>
                      </select>
                  </div>
                  <div class="form-group ">
                      <label>Trajet<span class="text-danger">*</span></label>
                      <!-- <v-select :options="trajets" label="libelle" v-model="form.trajet_id" :reduce="trajets => trajets.id" @input="setTrajetDatas"/> -->
                      <select class="form-control" v-model="form.trajet_id" @change="setTrajetDatas(form.trajet_id)">
                      <option v-for="trajet in trajets" :value="trajet.id" :key="trajet.id">{{ trajet.libelle }}</option>
                      </select>
                  </div>
                  <div class="form-group ">
                      <label>Depart<span class="text-danger">*</span></label>
                      <input type="date" v-model="form.date_chargement"  class="form-control" required>
                  </div>
                  <div class="form-group ">
                      <label>Arrivée</label>
                      <input type="date" v-model="form.date_dechargement" class="form-control">
                  </div>
                  <div class="form-group ">
                      <label>Adresse de chargement<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" v-model="form.adresse_chargement">
                  </div>
                  <div class="text-center">
                      <button v-if="form.adresse_chargement && form.adresse_dechargement" class="btn btn-outline-info rounded-pill" type="button" @click.prevent="echangerAdresses()" required>
                          <ion-icon :icon="swapVertical" class="setting"/>
                      </button>
                  </div>
                  <div class="form-group ">
                      <label>Adresse de déchargement<span class="text-danger">*</span></label>
                      <input type="text" v-model="form.adresse_dechargement" class="form-control" required>
                  </div>
                  <div class="form-group ">
                      <label>Marchandise à transporter</label>
                      <textarea name="description" rows="3" v-model="form.description" class="form-control"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary mt-4" >
                  <span v-if="this.$store.state.isLoading === true" class="spinner-border spinner-border-sm" role="status"
                      aria-hidden="true"></span>
                  <i class="fa fa-save"></i> Réserver
                  </button>
              </form>
            </div>
           </ion-content>
        </template>
    </my-template>
</template>y

<script lang="ts">
import moment from 'moment'
import { swapVertical } from 'ionicons/icons';

  export default {
    data () {
      return {
        nom: '',
        isLoading: false,
        swapVertical,
        mode: 'create',
        types_camions: [],
        key: 1,
        step: 1,
        trajets: [],
        camions: [],
        clients: [],
        isOpen: true,
        form: {
          type_course: '',
          date_chargement: '',
          date_dechargement: '',
          adresse_chargement: '',
          adresse_dechargement: '',
          trajet_id: 0,
          client_id: this.$store.state.user.id,
          description: '',
          etat: 'demande'
        }
      }
    },
    mounted(){

      this.form.date_chargement = moment().format('YYYY-MM-DD');
      this.getCamions()
      this.getTrajets()
      this.getClients()
      
    },
    
    methods: {

    setTrajetDatas(value) {
      if (value) {
        let trajet = this.trajets.filter(item => item.id === value)
        this.form.type_camion = trajet[0].type_camion
        
        this.form.ration = trajet[0].ration
        this.form.adresse_chargement = trajet[0].depart
        this.form.adresse_dechargement = trajet[0].arrivee
      }
    },
    echangerAdresses() {
      let varTemp = this.form.adresse_chargement
      this.form.adresse_chargement = this.form.adresse_dechargement
      this.form.adresse_dechargement = varTemp
    },
    getClients() {
     
      this.axios.get('/api/users?type_user=client').then((response) => {
        this.clients = response.data
         this.$store.state.isLoading = false
      }).catch(error => {
        this.errors = error.response.data.errors
        this.key++
        this.showErrors = true
         this.$store.state.isLoading = false
        this.$toast.error('Une erreur s\'est produite lors de la récupération !')
      })
    },
    getTrajets() {
   
      this.axios.get('/api/trajets').then((response) => {
        this.trajets = response.data
        this.$store.state.isLoading = false
      }).catch(error => {
        this.errors = error.response.data.errors
        this.key++
        this.showErrors = true
         this.$store.state.isLoading = false
        this.$toast.error('Une erreur s\'est produite lors de la récupération !')
      })
    },
   
    getCamions() {
      this.$store.state.isLoading = true
      this.axios.get('/api/camions?statut=Disponible').then((response) => {
        this.camions = response.data
         this.$store.state.isLoading = false
      }).catch((error) => {
        this.errors = error.response.data
        this.key++
         this.$store.state.isLoading = false
      
      })
    },
    createLine() {
      this.$store.state.isLoading = true
      this.axios.post('/api/course_demandes', this.form)
        .then((response) => {
          this.$store.state.isLoading = false
          if (response.data.success === true) {
            this.$toast.add({
              severity: 'success',
              detail: response.data.message,
              life: 3000
            });
            this.resetForm()
            this.$router.push({ name: 'accueil' })
           
          } else {
            this.$toast.add({
              severity: 'error',
              summary: 'Erreur d\'enregistrement',
              detail: response.data.errors[0],
              life: 5000
            });
          }
        }).catch((error) => {
          console.log(error)
          this.$store.state.isLoading = false
        
        })
    },
    resetForm() {
      this.step = 1,
        this.form = {
          type_course: '',
          date_chargement: '',
          date_dechargement: '',
          adresse_chargement: '',
          adresse_dechargement: '',
          trajet_id: 0,
          client_id: this.$store.state.user.id,
          description: '',
        }
    },
      
    }
  };
</script>