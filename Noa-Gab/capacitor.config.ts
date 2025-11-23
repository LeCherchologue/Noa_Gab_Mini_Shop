import { CapacitorConfig } from '@capacitor/cli';
import store from './src/store/index.ts';
import { createApp } from 'vue'

const config: CapacitorConfig = {
  appId: 'io.ionic.starter',
  appName: 'Yams Transporteur',
  webDir: 'dist',
  server: { 
    url: store.getters.appUrl,
    cleartext: true
   }
};

// if (navigator.onLine === true) {
//   config.server.url = store.getters.appUrl;
// } else {
//   config.server?.androidScheme
// }

export default config;
