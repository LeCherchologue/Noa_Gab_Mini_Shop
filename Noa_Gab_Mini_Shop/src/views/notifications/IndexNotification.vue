<template>
  <ActionTemplate>
    <template #page_title>
      <h6>NOTIFICATIONS</h6>
    </template>
    <template #content>
      <div v-if="notifications.length > 0">
        <button @click="readAllNotif()" class="btn btn-sm btn-light btn-block mb-3">Marquer toutes les notifications
          comme lues</button>
        <ion-list>
          <ion-item v-for="notification in notifications" :key="notification.id" class="d-flex align-items-center"
            :class="{ 'non_lu': notification.read_at == null }" @click="openModal(notification)">
            <img :src="notification.data.user_photo" alt="Notification Image" class="mr-3 rounded"
              style="width: 50px; height: 50px;">
            <ion-label>
              <small>{{ notification.data.libelle }}</small><br>
              <small class="mr-2">{{ notification.created_at }}</small>
            </ion-label>
          </ion-item>
        </ion-list>
        <ion-infinite-scroll threshold="100px" @ionInfinite="getNotifications">
          <ion-infinite-scroll-content loadingSpinner="bubbles"
            loadingText="Chargement des notifications..."></ion-infinite-scroll-content>
        </ion-infinite-scroll>
      </div>
      <div v-else-if="notifications.length < 1 && isLoading === false">
        <p class="text-center py-5">Vous n'avez pas de notification</p>
      </div>

      <!-- modal  notif selectionné -->
      <ShowNotification v-if="isModalOpen" :isOpen="isModalOpen" :notification="selectedLine" @close="closeModal" />
    </template>
  </ActionTemplate>
</template>

<script>
import $ from "jquery"
import { defineComponent } from 'vue';
import ShowNotification from "./ShowNotification.vue"
import { mapActions } from 'vuex';

export default defineComponent({
  components: { ShowNotification },
  inject: ['dialogRef'],
  data() {
    return {
      resIsLoading: true,
      isLoading: false,
      start: 0,
      limit: 10,
      table: "notifications",
      notifications: [],
      selectedLine: {},
      isModalOpen: false,
    };
  },
  mounted() {
    this.getNotifications()
  },

  methods: {
    ...mapActions(['fetchNotifications']),
    // pushTo(name, param) {
    //   this.dialogRef.close()
    //   this.$router.push({ name: name, params: { id: param } })
    // },
    async getNotifications(event) {
      this.resIsLoading = true
      try {
        const rangeEnd = this.start + this.limit - 1;
        const response = await this.axios.get('/api/notifications', {
          headers: {
            Range: `bytes=${this.start}-${rangeEnd}`,
          },
        });

        this.fetchNotifications()

        // Ajout des nouvelles données
        this.notifications = [...this.notifications, ...response.data];

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
    async readAllNotif() {
      this.isLoading = true
      await this.axios.post('/api/notifications/read-all').then(() => {
        this.fetchNotifications()
      }).catch(() => {
        this.$toast.add({
          severity: 'error',
          summary: 'Probleme de connexion',
          detail: 'Une erreur s\'est produite lors de la connexion au serveur !',
          life: 5000
        });
      })
    },
    readNotif(id) {
      this.selectedLine = this.notifications.filter(item => item.id == id)[0]
      this.axios.post('/api/notifications/' + id + '/read').then(() => {
        $('#refresh' + this.table).click()
      })
      this.getNotifications()
    },
    openModal(notification) {
      this.selectedLine = notification;
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.selectedLine = null;
    },
  },

});
</script>

<style scoped>
#list .list-group-item:hover {
  background-color: #3142C5 !important;
  color: #fff !important;
  border-radius: 0px !important;
}

#list .list-group-item {
  border-radius: 0px !important;
}
</style>