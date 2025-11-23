<template>
    
    <ion-content>
        <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar>
        <div class="container">
            <h5 class="mb-3">Notifications</h5>
            <ul class="list-group list-group-flush">
                <li  v-for="notification in notifications" :key="notification.id" class="list-group-item" :class="{'non_lu': notification.read_at == null}" @click="openDetail(notification)">
                  <span class="">{{ showUser(notification.data) }} {{ showLibelle(notification.data) }} </span>
                </li>   
            </ul>
        </div>
        <ion-modal :is-open="detailNotif" id="modal">
            <ion-header>
                <ion-toolbar color="primary" id="toolbar">
                  <ion-buttons slot="end">
                    <ion-button @click="closeDetail()" :strong="true">x</ion-button>
                  </ion-buttons>
                </ion-toolbar>
            </ion-header>
            <ion-content>
                <DetailNotification :data="notif"></DetailNotification>
            </ion-content>
        </ion-modal>
    </ion-content>
</template>



<style>
    #tool{
        background-color: black;
    }
    #modal {
        --height: 30%;
        --border-radius: 16px;
        --box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
      }
      
      #modal::part(backdrop) {
        background: rgba(209, 213, 219);
        opacity: 1;
      }
      
      #modal #toolbar {
        --background: rgb(14 116 144);
        --color: white;
      }

</style>

<script lang="ts">
import { defineComponent, defineAsyncComponent } from 'vue';
const DetailNotification = defineAsyncComponent(() => import('./DetailNotification.vue'));
export default defineComponent({
    components: {DetailNotification},
  data() {
    return {
      isLoading: false,
      notifications: this.$store.state.notifications,
      detailNotif: false,
      notif: []
    };
    },
  methods: {
    openDetail(data){
        this.detailNotif = true
        this.notif = data
    },
    closeDetail(){
        this.detailNotif = false
    },
    showUser(val) {
        let notification = JSON.parse('[' + val + ']')
        return notification[0].user_name
    },

    showLibelle(val) {
        let notification = JSON.parse('[' + val + ']')
        return notification[0].libelle
    },
    async getNotifications() {
        await this.axios.get('/api/notifications').then((response) => {
            this.isLoading = false
            this.notifications = response.data
            this.$store.commit('setNotifications', response.data)
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
   
    readNotif(notification) {
        if (notification.read_at == null) {
            this.axios.post('/api/notifications/'+notification.id+'/read').then((response) => {
                this.getNotifications()
            })
        }
        
    },
  }
});
</script>
  