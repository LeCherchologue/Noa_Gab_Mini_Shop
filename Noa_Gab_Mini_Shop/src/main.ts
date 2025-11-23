import 'jquery/dist/jquery'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import "@lottiefiles/lottie-player";

import { createApp } from 'vue'
import App from './App.vue'
import router from './router';
import store from './store'
import MyTemplate from './views/layouts/MyTemplate.vue'
import ActionTemplate from './views/layouts/ActionTemplate.vue'
import axios from 'axios';
import VueAxios from 'vue-axios';
import { GoogleAuth } from '@codetrix-studio/capacitor-google-auth';

import {
  IonicVue,
  IonTitle,
  IonModal,
  IonIcon,
  IonPage,
  IonContent,
  IonHeader,
  IonToolbar,
  IonTabs,
  IonRouterOutlet,
  IonTabBar,
  IonTabButton,
  IonLabel,
  IonList,
  IonItem,
  IonFab,
  IonFabButton,
  IonFabList,
  IonMenu,
  IonMenuButton,
  IonButton,
  IonFooter,
  IonInput 
} from '@ionic/vue';


/* Core CSS required for Ionic components to work properly */
import '@ionic/vue/css/core.css';

/* Basic CSS for apps built with Ionic */
import '@ionic/vue/css/normalize.css';
import '@ionic/vue/css/structure.css';
import '@ionic/vue/css/typography.css';

/* Optional CSS utils that can be commented out */
import '@ionic/vue/css/padding.css';
import '@ionic/vue/css/float-elements.css';
import '@ionic/vue/css/text-alignment.css';
import '@ionic/vue/css/text-transformation.css';
import '@ionic/vue/css/flex-utils.css';
import '@ionic/vue/css/display.css';

/**
 * Ionic Dark Mode
 * -----------------------------------------------------
 * For more info, please see:
 * https://ionicframework.com/docs/theming/dark-mode
 */

/* @import '@ionic/vue/css/palettes/dark.always.css'; */
/* @import '@ionic/vue/css/palettes/dark.class.css'; */
import '@ionic/vue/css/palettes/dark.system.css';

/* Theme variables */
import './theme/variables.css';

// import { LocalNotifications } from '@capacitor/local-notifications';
// import { PushNotifications } from '@capacitor/push-notifications';



axios.defaults.withCredentials = true
axios.defaults.baseURL = store.getters.apiUrl

axios.defaults.headers.common = {
  'Authorization': 'Bearer ' + store.getters.user.token,
};
axios.defaults.baseURL = store.getters.apiUrl


// if(localStorage.getItem("yams_user_session") !== null){
//   const user = JSON.parse(localStorage.getItem("yams_user_session"));
//   store.commit('setAuthenticated', user);

  // se connecter au canal privé de l'utilisateur connecté
  // const channel = pusher.subscribe('notifications.'+user.id);
  //     channel.bind('content', function(data: any) {
  //     console.log('test ws privé', data.message)
  //     alert(data.message);
  // });
// }

// if(localStorage.getItem("yams_client_opened_at") !== null){
//   const hasSeenDidactitielAt = JSON.parse(localStorage.getItem("yams_client_opened_at"));
//   store.commit('setHasSeenDidactitielAt', hasSeenDidactitielAt);
// }

// Ajoutez un intercepteur de réponse
axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response && error.response.status === 401) {
      // Code 401 détecté, déconnexion de l'utilisateur
      store.commit('clearUserData'); // Supprimez le token ou les infos de l'utilisateur
      router.push({ name: 'login' }); // Redirigez vers la page de connexion
    }
    return Promise.reject(error);
  }
);

const app = createApp(App)
  .use(IonicVue)
  .use(router)
  .use(store)
  .use(VueAxios, axios);

app.component('IonPage', IonPage);
app.component('IonContent', IonContent);
app.component('IonHeader', IonHeader);
app.component('IonToolbar', IonToolbar);
app.component('IonTabs', IonTabs);
app.component('IonRouterOutlet', IonRouterOutlet);
app.component('IonTabBar', IonTabBar);
app.component('IonTabButton', IonTabButton);
app.component('IonLabel', IonLabel);
app.component('IonList', IonList);
app.component('IonItem', IonItem);
app.component('IonFab', IonFab);
app.component('IonFabButton', IonFabButton);
app.component('IonFabList', IonFabList);
app.component('IonIcon', IonIcon);
app.component('IonModal', IonModal);
app.component('IonMenu', IonMenu);
app.component('IonMenuButton', IonMenuButton);
app.component('IonFooter', IonFooter);
app.component('IonButton', IonButton);
app.component('IonTitle', IonTitle);
app.component('IonInput', IonInput);

app.component('MyTemplate', MyTemplate);
app.component('ActionTemplate', ActionTemplate);

router.isReady().then(() => {
  app.mount('#app');
});


// google sign in
// GoogleAuth.initialize({
//   clientId: '786884809938-g3qvd3qtulosvghlcu7b3cfsfiu363b1.apps.googleusercontent.com',
//   scopes: ['profile', 'email'],
//   grantOfflineAccess: true,
// });

//demander la permission d'afficher les notification
// PushNotifications.requestPermissions()

// LocalNotifications.requestPermissions().then(permission => {
//   if (permission.display === 'granted') {
//     console.log('Notification permission granted.');
//   } else {
//     console.log('Notification permission denied.');
//   }
// });

