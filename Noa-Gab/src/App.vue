<template>
  <ion-app >
    <div v-if="statut == true">
      <ion-router-outlet/>
    </div>
    <div v-else>
      <h2>Aucune connexion, veuillez vous connecter à internet !</h2>
    </div>
  </ion-app>
  <ShowToast position="top-center" />
  <DynamicDialog/>
</template>

<!-- <script setup lang="ts">
  import { IonApp, IonRouterOutlet} from '@ionic/vue';
</script> -->

<script lang="ts">
import { Network } from '@capacitor/network';
import { defineComponent } from 'vue';
import Capacitor from '../capacitor.config'
export default defineComponent({
  data() {
    return {
      statut: false
    };
  },

  created() {
    
    this.statut = navigator.onLine
    if (navigator.onLine) {
      Capacitor.server.url = this.$store.getters.appUrl
      Capacitor.server.cleartext = true
    }
    else{
      Capacitor.server.androidScheme = 'https'
    }
    Network.getStatus().then(status => {
      console.log('reseau = ', Capacitor)
    })
  },
 
  methods: {
   
  }
});
</script>

<style lang="scss">
  @import './style/app.scss';
</style>

<style>
#main {
  padding-top: 70px;
}

</style>