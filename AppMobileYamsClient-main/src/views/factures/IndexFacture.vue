<template>
  <my-template>
    <template #content>
      <ion-title size="large" class="text-primary font-weight-bold mt-3">FACTURES</ion-title>
      <ion-progress-bar v-if="resIsLoading == true && start == 0" type="indeterminate"></ion-progress-bar>
      <div class="container pt-3">
        <!-- liste des courses de l'onglet sélectionné -->
        <ion-list>
          <ion-item v-for="course in courses" :key="course.id" @click="openModal(course)">
            <ion-label>
              <div class="d-flex align-items-center row">
                <div class="col-7">
                  Facture n° {{ course.id }} de la course {{ course.code }}
                </div>
                <div class="col-5 text-right">
                  <b>{{ formatPriceWithDevise(course.trajet.montant) }} </b>
                </div>
              </div>
            </ion-label>
          </ion-item>
        </ion-list>
        <ion-infinite-scroll threshold="100px" @ionInfinite="getCourses">
          <ion-infinite-scroll-content loadingSpinner="bubbles"
            loadingText="Chargement des données..."></ion-infinite-scroll-content>
        </ion-infinite-scroll>
      </div>

      <!-- modal de la facture sélectionnée -->
      <ModalShowFacture :isOpen="isModalOpen" :course="selectedLine" @close="isModalOpen = false" />
    </template>
  </my-template>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';
import ModalShowFacture from './ModalShowFacture.vue';


export default defineComponent({
  components: { ModalShowFacture },
  data() {
    return {
      resIsLoading: true,
      isLoading: true,
      start: 0,
      limit: 10, // Augmentez la limite si vous souhaitez charger plus de factures à chaque demande
      tab: 'En cours',
      courses: [],
      baseUrl: this.$store.state.api_yams_livraisons,
      isModalOpen: false,
      selectedLine: null,
    };
  },
  mounted() {
    this.getCourses();
  },
  methods: {
    formatPriceWithDevise(val) {
      if (val) return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'XAF' }).format(val)
    },
    async presentToast(position: 'top' | 'middle' | 'bottom', msg, duration, color) {
      const toast = await toastController.create({
        message: msg,
        duration: duration,
        position: position,
        color: color,
      });
      await toast.present();
    },
    async getCourses(event) {
      this.resIsLoading = true
      try {
        const rangeEnd = this.start + this.limit - 1;
        const response = await this.axios.get(this.baseUrl + '/api/courses', {
          headers: {
            Range: `bytes=${this.start}-${rangeEnd}`,
          },
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
        console.log(error);
        this.resIsLoading = false
        if (event) {
          event.target.complete();
        }
      }
    },
    openModal(course) {
      this.selectedLine = course;
      this.isModalOpen = true;
    },
  },
});
</script>

<style scoped>
/* Animation Lottie pour les factures */
.facture-animation {
  width: 50px;
  height: 50px;
}
</style>