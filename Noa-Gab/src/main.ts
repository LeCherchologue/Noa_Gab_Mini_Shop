import 'jquery/dist/jquery'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
// import "primevue/resources/themes/bootstrap4-light-blue/theme.css"
import "@lottiefiles/lottie-player";

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
import PrimeVue from 'primevue/config';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import MyTemplate from './views/layouts/MyTemplate.vue'
import TemplateCommerce from './views/layouts/TemplateCommerce.vue';
import ProgressBar from 'primevue/progressbar';
import FileUpload from 'primevue/fileupload';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import Badge from 'primevue/badge'
import Tag from 'primevue/tag';
import Dialog from 'primevue/dialog';
import Card from 'primevue/card';
import DynamicDialog from 'primevue/dynamicdialog'
import DialogService from 'primevue/dialogservice'
import ListPaginated from './components/ListPaginated.vue'


import { IonModal, IonIcon, IonPage, IonContent, IonHeader, IonToolbar, IonTabs, IonRouterOutlet, IonTabBar, IonTabButton, IonLabel, IonList, IonItem, IonFab, IonFabButton, IonFabList, IonMenu, IonMenuButton, IonMenuToggle, IonTitle, IonButton, IonProgressBar,  IonCard, IonCardContent, IonCardHeader, IonCardSubtitle, IonCardTitle, modalController } from '@ionic/vue';
import TopBar from '@/views/layouts/TopBar.vue';
import BottomBar from '@/views/layouts/BottomBar.vue'
import Paginator from 'primevue/paginator';

import { IonicVue } from '@ionic/vue';

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

/* Theme variables */
import './theme/variables.css';

axios.defaults.withCredentials = true
axios.defaults.baseURL = store.getters.apiUrl

if(localStorage.getItem("yams_user_session") !== null){
  const user = JSON.parse(localStorage.getItem("yams_user_session"));
  store.commit('setAuthenticated', user);
}

if(localStorage.getItem("yams_configuration") !== null){
  const first_connexion = localStorage.getItem("yams_configuration");
  store.commit('setConfiguration', first_connexion);
}
// axios.defaults.headers.common = {
//   'Authorization': 'Bearer ' + store.getters.user.token,
// };


axios.interceptors.response.use((response) => {
  if (response.status == 401) {
    router.push({ name: 'login' })
  } else {
    return response
  }
},(error) => {
    if (error.response.status == 401) {
      router.push({ name: 'login' })
    }
  },
);


const app = createApp(App)
  .use(VueAxios, axios)
  .use(IonicVue)
  .use(router)
  .use(store)
  .use(PrimeVue)
  .use(ToastService)
  .use(DialogService);

app.component('ShowToast', Toast);
app.component('MyTemplate', MyTemplate);
app.component('TemplateCommerce', TemplateCommerce);
app.component('ProgressBar', ProgressBar);
app.component('IonPage', IonPage);
app.component('IonContent', IonContent);
app.component('IonHeader', IonHeader);
app.component('IonToolbar', IonToolbar);
app.component('IonTabs', IonTabs);
app.component('IonRouterOutlet', IonRouterOutlet);
app.component('IonTabBar', IonTabBar);
app.component('IonButton', IonButton);
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
app.component('IonMenuToggle', IonMenuToggle);
app.component('TopBar', TopBar);
app.component('BottomBar', BottomBar);
app.component('FileUpload', FileUpload);
app.component('Paginator', Paginator);
app.component('Accordion', Accordion);
app.component('AccordionTab', AccordionTab);
app.component('Badge', Badge);
app.component('Tag', Tag);
app.component('Card', Card);
app.component('Dialog', Dialog);
app.component('DynamicDialog', DynamicDialog);
app.component('ListPaginated', ListPaginated);
app.component('IonTitle', IonTitle);
app.component('IonProgressBar', IonProgressBar);
app.component('IonCard', IonCard);
app.component('IonCardContent', IonCardContent);
app.component('IonCardHeader', IonCardHeader);
app.component('IonCardSubtitle', IonCardSubtitle);
app.component('IonCardTitle', IonCardTitle);
app.component('modalController', modalController);

router.isReady().then(() => {
  app.mount('#app');
});

