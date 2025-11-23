import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';
import store from '../store';
import HomePage from '@/views/HomePage.vue';
import StarterPage from '@/views/StarterPage.vue';
import LoginView from '@/auth/LoginView.vue';
import RegisterView from '@/auth/RegisterView.vue';
import VerifyAccount from '@/auth/VerifyAccount.vue';
import MyAccount from '@/auth/MyAccount.vue';
import IndexNotification from '@/views/notifications/IndexNotification.vue';
import CreateReservation from '@/views/reservations/CreateReservation.vue';
import IndexCourse from '@/views/courses/IndexCourse.vue';
import IndexFacture from '@/views/factures/IndexFacture.vue';
import IndexChat from '@/views/chat/IndexChat.vue';
import ShowDemandes from '@/views/courses/ShowDemandes.vue';
import ShowChat from '@/views/chat/ShowChat.vue';
import CreateChat from '@/views/chat/CreateChat.vue';
import ModalSignaler from '@/views/courses/ModalSignaler.vue';
import ForgotPasswordPage from '@/auth/ForgotPasswordPage.vue';
import ResetPasswordPage from '@/auth/ResetPasswordPage.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    redirect: '/home'
  },
  {
    path: '/starter',
    name: 'starter',
    component: StarterPage
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView
  },
  {
    path: '/verify-account',
    name: 'verify.account',
    component: VerifyAccount
  },
  {
    path: '/account',
    name: 'account',
    component: MyAccount
  },
  {
    path: '/notifications',
    name: 'notifications',
    component: IndexNotification
  },
  {
    path: '/home',
    name: 'home',
    component: HomePage
  },
  {
    path: '/reservation/create',
    name: 'reservation.create',
    component: CreateReservation
  },
  {
    path: '/courses',
    name: 'courses.index',
    component: IndexCourse
  },
  {
    path: '/factures',
    name: 'factures.index',
    component: IndexFacture
  },
  {
    path: '/demandes',
    name: 'demandes.show',
    component: ShowDemandes
  },
  {
    path: '/chat',
    name: 'chat.index',
    component: IndexChat
  },
  {
    path: '/chat/:id_ticket',
    name: 'chat.show',
    component: ShowChat,
    props: true,
  },
  {
    path: '/chat/nouveau',
    name: 'chat.create',
    component: CreateChat
  },
  {
    path: '/factures/signaler',
    name: 'modal.signaler',
    component: ModalSignaler
  },
  {
    path: '/forgot-password',
    name: 'forgot-password',
    component: ForgotPasswordPage
  },
  {
    path: '/reset-password',
    name: 'reset-password',
    component: ResetPasswordPage
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.name !== 'starter' && store.getters.hasSeenDidactitielAt == null) {
    next({ name: 'starter' })
  }
  else if (to.name !== 'login' && to.name !== 'register' && to.name !== 'forgot-password' && !store.getters.authenticated) {
     next({ name: 'login' })
  }
  // else if (to.name !== 'verify.account' && store.getters.user.verifiedAccount != 1  && store.getters.authenticated) {
  //   next({ name: 'verify.account' })
  // }
  else next()
})

export default router
