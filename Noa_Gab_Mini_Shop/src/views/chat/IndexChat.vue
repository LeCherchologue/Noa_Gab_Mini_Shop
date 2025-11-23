<template>
  <my-template>
    <template #content>
      <ion-title size="large" class="text-primary font-weight-bold mt-3">CHAT</ion-title>
      <ion-progress-bar v-if="resIsLoading == true && start == 0" type="indeterminate"></ion-progress-bar>

      <!-- afficher un message quand l'utilisateur n'a pas de ticket -->
      <p v-else-if="resIsLoading == false && tickets.length < 1" class="text-center py-3 px-1" >
        Vous n'avez pas encore de tickets
      </p>

      <!-- liste des courses de l'onglet sélectionné -->
      <ion-list>
        <ion-item v-for="ticket in tickets" :key="ticket.id" style="cursor: pointer;" @click="openTicket(ticket.id)">
          <ion-label>
            <div class="d-flex align-items-center row">
              <div class="col-9">
                <p>{{ ticket.sujet }}</p>
                <span class="font-weight-bold">{{ ticket.service.libelle }}</span><br>
                <small class="font-italic">Ticket #{{ ticket.id }} : <b>{{ ticket.nb_messages }}</b> messages</small>
              </div>
              <div class="col-3 text-center">
                <span class="badge font-weight-bold"
                  :class="{ 'badge-success': ticket.statut == 'Ouvert' , 'badge-secondary' : ticket.statut == 'Fermé' }">{{
                  ticket.statut }}</span>
              </div>
            </div>
          </ion-label>
        </ion-item>
      </ion-list>

      <!-- bouton flottant de la nouvelle reservation -->
      <ion-fab horizontal="end" vertical="bottom" slot="fixed">
        <ion-fab-button @click.prevent="openNewTicket">
          <i class="fa-solid fa-comment"></i>
        </ion-fab-button>
      </ion-fab>

      <!-- Scroll pour defiler la liste -->
      <ion-infinite-scroll threshold="100px" @ionInfinite="getTickets">
        <ion-infinite-scroll-content loadingSpinner="bubbles"
          loadingText="Chargement des données..."></ion-infinite-scroll-content>
      </ion-infinite-scroll>

    </template>
  </my-template>
</template>
<script lang="ts">
import { defineComponent, defineAsyncComponent } from 'vue';
import { toastController } from '@ionic/vue';
const ShowChat = defineAsyncComponent(() => import('./ShowChat.vue'));

export default defineComponent({
  data() {
    return {
      resIsLoading:true,
      tickets: [],
      start: 0,
      limit: 3,
      baseUrl: this.$store.state.api_yams_livraisons
    };
  },
  mounted() {
    this.getTickets();
  },
  methods: {
    async openTicket(id) {
      this.$router.push({ name: 'chat.show', params: { id_ticket: id } });
    },
    openNewTicket() {
      this.$router.push({ name: 'chat.create' });
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
    async getTickets(event) {
      this.resIsLoading = true
      try {
        const rangeEnd = this.start + this.limit - 1;
        const response = await this.axios.get(this.baseUrl + '/api/tickets', {
          headers: {
            Range: `bytes=${this.start}-${rangeEnd}`
          }
        });

        // Ajout des nouvelles données
        this.tickets = [...this.tickets, ...response.data];

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
  }
});
</script>

<style scoped>
.chat-container {
  max-width: 600px;
  margin: auto;
  height: 80vh;
  display: flex;
  flex-direction: column;
}

.chat-messages {
  flex: 1;
  overflow-y: auto;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-bottom: 10px;
}

.message {
  margin-bottom: 10px;
}

.message.sent {
  text-align: right;
}

.message.received {
  text-align: left;
}

.message .content {
  display: inline-block;
  padding: 10px;
  border-radius: 10px;
}

.message.sent .content {
  background-color: #007bff;
  color: white;
}

.message.received .content {
  background-color: #f1f1f1;
  color: black;
}
</style>