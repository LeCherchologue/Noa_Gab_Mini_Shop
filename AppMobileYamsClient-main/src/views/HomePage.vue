<template>
  <my-template>
    <template #content>
      <!-- entete avec la photo -->
      <a href="https://web.yamslogistics.com" target="_blank" class="btn p-0">
        <img src="/src/assets/IMG2.png" class="w-100 rounded mb-3">
      </a>
      <div class="container">
        <!-- partie des reservation -->
        <h6 class="text-dark font-weight-bold">Mes réservations</h6>

        <ul class="list-group mb-4">
          <router-link :to="{ name: 'courses.index' }">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              En cours
              <span class="badge badge-primary badge-pill">{{ locationEnCours }}</span>
            </li>
          </router-link>
          <router-link :to="{ name: 'demandes.show' }">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              En attente
              <span class="badge badge-primary badge-pill">{{ locationEnAttente }}</span>
            </li>
          </router-link>
        </ul>

        <!-- lien pour creer une reservations -->
        <router-link :to="{ name: 'reservation.create' }" class="btn btn-lg btn-block btn-primary">
          <i class="fa-solid fa-plus"></i> Reserver une course
        </router-link>
      </div>
    </template>
  </my-template>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  data() {
    return {
      locationEnCours: 0,
      locationEnAttente: 0,
      locationTermine: 0,
      baseUrl: this.$store.state.api_yams_livraisons
    };
  },
  mounted() {
    this.getCourses()
    this.getDemandes()
  },
  methods: {
    getCourses() {

      this.axios.get(this.baseUrl + '/api/courses?etat=En cours&req_count=1').then((response) => {
        this.locationEnCours = response.data
      }).catch(() => {

      })
    },
    getDemandes() {
      this.axios.get(this.baseUrl + '/api/demandes?statut=En attente&req_count=1').then((response) => {
        this.locationEnAttente = response.data
      }).catch(() => {
      })
    },
  }
});
</script>