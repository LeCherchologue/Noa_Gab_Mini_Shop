import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';
import LoginView from '../auth/LoginView.vue'
import HomePage from '../views/HomePage.vue'
import CourseIndex from '../views/courses/CourseIndex.vue'
import PaiementIndex from '../views/factures/PaiementIndex.vue'
import MyProfil from '../auth/MyProfil.vue'
import notifications from '../components/Notifications.vue'
import CourseShow from '../views/courses/CourseShow.vue'
import CourseDemande from '../views/courses/CourseDemande.vue'
import DetailNotification from '../components/DetailNotification.vue'
import CamionIndex from '@/views/camion/CamionIndex.vue';
import AnnonceIndex from '@/views/annonces/AnnoncesIndex.vue';
import CamionShow from '@/views/camion/CamionShow.vue'
import CourseCamion from '@/views/camion/courses/CourseCamion.vue'
import AffectationIndex from '@/views/affectations/AffectationIndex.vue';
import InterventionIndex from '@/views/interventions/InterventionIndex.vue';
import ClientIndex from '@/views/clients/ClientIndex.vue'
import AnnonceCreateVue from '@/views/annonces/AnnonceCreate.vue'
import ClientCreate from '@/views/clients/ClientCreate.vue';
import ChauffeurIndex from '@/views/chauffeurs/ChauffeurIndex.vue';
import CourseChauffeur from '@/views/chauffeurs/courses/CourseIndex.vue'
import InscriptionView from '@/auth/InscriptionView.vue';
import RegisterView from '@/auth/RegisterView.vue';
import ChatIndexVue from '@/views/chat/ChatIndex.vue';
import ChatShowVue from '@/views/chat/ChatShow.vue';
import StartVue from '@/views/StarterView.vue';
import store from '../store'
import { ExceptionCode } from '@capacitor/core';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    redirect: '/starter'
  },
  {
    path: '/starter',
    name: 'starter',
    component: StartVue
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/accueil',
    name: 'accueil',
    component: HomePage
  },
  {
    path: '/courses',
    name: 'courses',
    component: CourseIndex
  },
  {
    path: '/courses/show/:id',
    name: 'courses.show',
    component: CourseShow
  },
  {
    path: '/camions/show/:id',
    name: 'camions.show',
    component: CamionShow
  },
  {
    path: '/paiements',
    name: 'paiements',
    component: PaiementIndex
  },
  {
    path: '/profil',
    name: 'profil',
    component: MyProfil
  },
  {
    path: '/notifications',
    name: 'notifications',
    component: notifications
  },
  {
    path: '/CourseDemande',
    name: 'CourseDemande',
    component: CourseDemande
  },
  {
    path: '/DetailNotification/:code/:id',
    name: 'DetailNotification',
    component: DetailNotification
  },
  {
    path: '/camions',
    name: 'camions',
    component: CamionIndex
  },
  {
    path: '/annonces',
    name: 'annonces',
    component: AnnonceIndex
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView
  },
  {
    path: '/camion/courses/:id',
    name: 'camion.courses',
    component: CourseCamion
  },
  {
    path: '/affectations',
    name: 'affectations',
    component: AffectationIndex
  },
  {
    path: '/interventions',
    name: 'interventions',
    component: InterventionIndex
  },
  {
    path: '/clients',
    name: 'clients',
    component: ClientIndex
  },
  {
    path: '/AnnonceCreateVue',
    name: 'AnnonceCreateVue',
    component: AnnonceCreateVue
  },
  {
    path: '/ClientCreate',
    name: 'ClientCreate',
    component: ClientCreate
  },
  {
    path: '/ChauffeurIndex',
    name: 'ChauffeurIndex',
    component: ChauffeurIndex
  },
  {
    path: '/CourseChauffeur',
    name: 'CourseChauffeur',
    component: CourseChauffeur
  },
  {
    path: '/InscriptionView',
    name: 'InscriptionView',
    component: InscriptionView
  },
  {
    path: '/chat',
    name: 'chat',
    component: ChatIndexVue
  },
  {
    path: '/ChatShow/:id/:service',
    name: 'ChatShow',
    component: ChatShowVue
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.name === 'starter' && store.state.first_connexion == 1) next({ name: 'login' })
  else next()
})

export default router
