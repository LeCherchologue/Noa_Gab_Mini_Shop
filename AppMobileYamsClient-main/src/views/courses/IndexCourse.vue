<template>
  <my-template>
    <template #content>
      <ion-title size="large" class="text-primary font-weight-bold mt-3">MES COURSES</ion-title>
      <div class="container pt-3">
        <!-- les onglets des etats des courses -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a
              class="nav-link"
              :class="{ active: tab === 'Programmé' }"
              id="programmé-tab"
              data-toggle="tab"
              href="#programmé"
              role="tab"
              aria-controls="programmé"
              aria-selected="true"
              @click="changeTab('Programmé')"
            >
              Programmé
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a
              class="nav-link"
              :class="{ active: tab === 'En cours' }"
              id="en-cours-tab"
              data-toggle="tab"
              href="#en-cours"
              role="tab"
              aria-controls="en-cours"
              aria-selected="false"
              @click="changeTab('En cours')"
            >
              En cours
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a
              class="nav-link"
              :class="{ active: tab === 'Terminé' }"
              id="terminé-tab"
              data-toggle="tab"
              href="#terminé"
              role="tab"
              aria-controls="terminé"
              aria-selected="false"
              @click="changeTab('Terminé')"
            >
              Terminé
            </a>
          </li>
        </ul>
      </div>

      <ion-progress-bar v-if="resIsLoading == true && start == 0" type="indeterminate"></ion-progress-bar>
      <p v-else-if="resIsLoading == false && courses.length < 1" class="text-center py-3 px-1">
        Vous n'avez pas de course ({{ tab }})
      </p>

      <!-- liste des courses de l'onglet sélectionné -->
      <ion-list>
        <ion-item v-for="course in courses" :key="course.id" @click="openModal(course)">
          <ion-label>
            <div class="d-flex align-items-center row">
              <div class="col-3 text-center">
                <img src="/images/default_photo.png" class="w-100 rounded-circle" style="max-width: 80px;">
              </div>
              <div class="col-6 text-center">
                <small>Chauffeur principal</small><br>
                <span class="font-weight-bold">{{ course.chauffeur_principal_nom}}</span><br>
                <small class="font-italic">{{ course.adresse_chargement }} - {{ course.adresse_dechargement }}</small>
              </div>
              <div class="col-3 text-center">
                <lottie-player v-if="tab=='En cours'" autoplay loop mode="normal" style="width: 100%" src="/json/truck_yams.json"></lottie-player>
                <i v-else-if="tab == 'Programmé'" class="fa-solid fa-hourglass-start" style="font-size: 2rem;"></i>
                <i v-else-if="tab == 'Terminé'" class="fa-solid fa-flag-checkered" style="font-size: 2rem;"></i>
              </div>
            </div>
          </ion-label>
        </ion-item>
      </ion-list>

      <!-- bouton flottant de la nouvelle reservation -->
      <ion-fab horizontal="end" vertical="bottom" slot="fixed">
        <ion-fab-button @click.prevent="newReservation">
          <i class="fa-solid fa-plus"></i>
        </ion-fab-button>
      </ion-fab>

      <!-- Scroll pour defiler la liste -->
      <ion-infinite-scroll threshold="100px" @ionInfinite="getCourses">
        <ion-infinite-scroll-content loadingSpinner="bubbles"
          loadingText="Chargement des données..."></ion-infinite-scroll-content>
      </ion-infinite-scroll>

      <!-- modal du vehicule selectionné -->
      <ModalShowCourse :isOpen="isModalOpen" :course="selectedLine" @close="closeModal" />
    </template>
  </my-template>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';
import ModalShowCourse from './ModalShowCourse.vue';
export default defineComponent({
  components: {ModalShowCourse},
  data() {
    return {
      resIsLoading: true,
      start: 0,
      limit: 1,
      tab: 'En cours',
      courses: [],
      baseUrl: this.$store.state.api_yams_livraisons,
      isModalOpen: false,
      selectedLine: null
    };
  },
  mounted() {
    this.getCourses();
  },
  methods: {
    changeTab(newTab: String){
      // changer l'onglet et recharger les données
      this.tab = newTab
      this.start = 0
      this.courses = []
      this.getCourses()
    },
    openModal(vehicule) {
      this.selectedLine = vehicule;
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.selectedLine = null;
    },
    async presentToast(position: 'top' | 'middle' | 'bottom', msg, duration, color) {
      const toast = await toastController.create({
        message: msg,
        duration: duration,
        position: position,
        color: color
      });

      await toast.present();
    },
    newReservation() {
      this.$router.push({ name: 'reservation.create' });
    },
    async getCourses(event) {
      this.resIsLoading = true
      try {
        const rangeEnd = this.start + this.limit - 1;
        const response = await this.axios.get(this.baseUrl + '/api/courses?etat=' + this.tab, {
          headers: {
            Range: `bytes=${this.start}-${rangeEnd}`
          }
        });

        // Ajout des nouvelles données
        this.courses = [...this.courses, ...response.data];

        // Mise à jour de la plage de requête
        this.start += this.limit;

        this.resIsLoading = false

        // Si event est défini, cela signifie que c'est une requête provenant de l'infinite scroll
        if (event) {
          event.target.complete();
        }
      } catch (error) {
        console.log(error)
        this.resIsLoading = false
        if (event) {
          event.target.complete();
        }
      }
    }
  },
});
</script>
