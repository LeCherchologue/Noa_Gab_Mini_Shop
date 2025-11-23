<template>
    <my-template>
      <template v-slot:content>
        <div class="container ion-padding">
          <h5 class="mb-3 font-weight-bold">Affectations</h5><br>
          <ul v-for="affectation in affectations" :key="affectation.id" class="list-group list-group-flush">
            <li v-if="affectation.date_debut != null || ffectation.date_fin != null" class="list-group-item d-flex justify-content-between align-items-center">
              <div v-if="affectation.date_debut != null || ffectation.date_fin != null">
                <small>Camion</small> <br>
                <span class="font-weight-bold ">{{ affectation.vehicule }}</span><br>
                <small class="font-italic ">{{ affectation.date_debut }} <p v-if="affectation.date_fin != null">{{ ' / ' +  affectation.date_fin }}</p></small>
              </div>
              <div>
                <button class="badge badge-primary p-2 rounded-pill">
                  {{ affectation.poste }}
                </button>
              </div>
            </li>
          </ul>
        </div>
      </template>
    </my-template>
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  
  export default defineComponent({
    data() {
      return {
        isLoading: true,
        affectations: []
      };
    },
    mounted(){
      this.getAffectations()
    },
   
    methods: {
      getAffectations(){
        this.axios.get('/api/affectations').then((response) => {
            this.isLoading = false
            this.affectations = response.data
            console.log('affectation = ',response.data)
        }).catch(() => {
        })   
      },
    }
  });
  </script>
  