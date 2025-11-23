<template>
  <div v-if="appIsLoading == true">
    <div class="overlay">
      <div class="overlay__inner">
        <div class="overlay__content">
          <span class="spinner"></span>
        </div>
      </div>
    </div>
  </div>
  <ion-app>
    <ion-router-outlet />
  </ion-app>
</template>

<script>
import { IonApp, IonRouterOutlet } from '@ionic/vue';
import { mapGetters, mapActions } from 'vuex';
import { LocalNotifications } from '@capacitor/local-notifications';
import Pusher from 'pusher-js';

// Pusher.logToConsole = true;
const pusher = new Pusher('829d13f31922516e15fd', {
  cluster: 'eu',
//   encrypted: true,
//     auth: {
//         headers: {
//             Authorization: `Bearer ${localStorage.getItem('token')}` 
//         }
//     }
});

//image de la notif
const localImagePath = './assets/logo1.png';

export default {
  component: { IonRouterOutlet, IonApp },
  computed: {
    ...mapGetters(['appIsLoading', 'authenticated', 'fetchInterval']),
  },
  // beforeMount() {
  //   // on se connecte à la chaine pour marquer la presence de l'utilisateur sur le reseau
  //   const channel = pusher.subscribe('notifications');
  //   channel.bind('content', function(data) {
  //       this.getUnreadNotifications()
  //       console.log('test ws', data.message)
  //   });

  //   if (this.authenticated == true) {
  //     //recharger les notif non lues
  //     this.fetchNotifications()
  //     //recharger les notif non lues apres 1minute
  //     this.fetchInterval = setInterval(() => {
  //       this.fetchNotifications()
  //     }, 60000);
  //   }
  // },
  // mounted() {
  //   this.getUnreadNotifications()
  // },
  // methods: {
  //   ...mapActions(['fetchNotifications']),
  //   async getUnreadNotifications() {
  //     this.isLoading = true
  //     await this.axios.get('/api/notifications?read_at=null').then((response) => {

  //       let lastUnreadNotifications = []
  //       //recuperation du tableau des notif envoyés
  //       if (localStorage.getItem("yams_user_session_notifications") !== null) {
  //         lastUnreadNotifications = JSON.parse(localStorage.getItem("yams_user_session_notifications"));
  //       }
               
  //       if (lastUnreadNotifications.length > 0) {
  //         let unreadNotifications = []

  //         response.data.forEach(element => {
  //           if (!element.includes(lastUnreadNotifications)) {
  //             unreadNotifications.push(element)
  //           }
  //         });

  //         unreadNotifications.forEach(element => {
  //           this.pushScheduleNotification(element)
  //         });
  //       }
  //       else {
  //         response.data.forEach(element => {
  //           this.pushScheduleNotification(element)
  //         });
  //       }

  //       // Fusionner les deux tableaux et stocké dans le storage
  //       const mergedNotifications = [...lastUnreadNotifications, ...unreadNotifications];
  //       window.localStorage.setItem('yams_user_session_notifications', JSON.stringify(mergedNotifications))

  //       this.isLoading = false
  //     }).catch(() => {
  //       this.isLoading = false
  //     })
  //   },
  //   async pushScheduleNotification(notif) {
  //     await LocalNotifications.schedule({
  //       notifications: [
  //         {
  //           title: notif.data.libelle,
  //           body: notif.data.description,
  //           id: 1,
  //           schedule: { at: new Date(Date.now() + 1000 * 5) }, // 5 seconds from now
  //           sound: null,
  //           attachments: [
  //                   { id: 'image', url: localImagePath, mimeType: 'image/jpeg' }
  //           ],
  //           actionTypeId: '',
  //           extra: null,
  //         },
  //       ],
  //     });
  //   },
  // },
}
</script>

<style lang="scss">
@import './style/app.scss';
</style>