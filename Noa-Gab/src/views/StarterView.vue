<template>
    <ion-header>
      <ion-toolbar>
        <div id="topbar">
          <div class="d-flex justify-content-between m-2 align-items-center">
             
              <div style="margin-left: 40%;">
                  <router-link to="/accueil">
                      <img src="/src/assets/yams.png" style="width: 70px;">
                  </router-link>
              </div>
             
          </div>
      </div>
      </ion-toolbar>
    </ion-header>
    <ion-content>
      
        <div class="ion-padding mt-5">
          <form v-if="step === 1" @submit.prevent="next()" style="position: relative;">
              <div style="height: 75vh; width: 100vw;">
                  <img src="/src/assets/devis.png" alt="" style="width: 100%;">
                  
                  <h3 class="mt-5">Bienvenue sur <b>Yam's Transporteur</b>, votre compagnon idéal pour suivre vos courses, depuis votre mobile</h3>
              </div>
              <button type="submit" class="btn btn-primary" style="position: absolute; right: 10px;">
                  Suivant
              </button>
              
          </form>
          
    
            <form v-else-if="step === 2" @submit.prevent="next()" style="position: relative;">
              <div style="height: 73vh; width: 100vw;">
                  <img src="/src/assets/geolocalisation.png" alt="" style="width: 100%;">
                  <h3 class="mt-5">Avec notre solution, localisez et suivez vos courses à n'importe quel endroit.</h3>
              </div>
             
              <div class="d-flex justify-content-between" >
              <a type="submit" class="btn btn-secondary mt-4" @click.prevent="prev()">
                  Précédent
              </a>
              <a href="/login" @click="configurationConnexion()" class="btn btn-primary mt-4">
                  Terminer
              </a>
              </div>
  
               
            </form>
        </div>
    </ion-content>
  </template>
  
  
  
  <script>
  import { defineComponent } from 'vue';
  
  export default defineComponent({
   
    data() {
        return {
          isLoading: true,
          step: 1,
          first_connexion: 1
        }
    },
    mounted(){
      console.log('first connexion = ', this.$store.state.first_connexion)
    },
    methods: {
        next() {
            this.step++
        },
        prev() {
            this.step--
        },
        configurationConnexion(){
          this.$store.commit('setConfiguration', this.first_connexion)
        }
    }
  })
  </script>