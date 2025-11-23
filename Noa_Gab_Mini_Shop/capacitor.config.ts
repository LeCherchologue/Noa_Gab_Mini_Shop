import type { CapacitorConfig } from '@capacitor/cli';
import store from './src/store/index.ts';
const config: CapacitorConfig = {
  // appId: 'io.ionic.starter',
  appId: 'mobile.yamslogistics.client',
  appName: 'Yams\'s Client',
  webDir: 'dist',
  
  server: { 
    url: store.getters.appUrl,
    cleartext:true
  },
  //config ajouté pour les notifications
  bundledWebRuntime: false,
  plugins: {
    LocalNotifications: {
      smallIcon: 'ic_stat_icon_config_sample',
      iconColor: '#488AFF',
      sound: 'beep.wav',
    },
    PushNotifications: {
      presentationOptions: ['badge', 'sound', 'alert'],
    },
    
    build: {
      rollupOptions: {
        external: ['@capacitor/push-notifications']
      }
    },

    "GoogleAuth": {
      "scopes": ["profile", "email"],
      "serverClientId": "786884809938-g3qvd3qtulosvghlcu7b3cfsfiu363b1.apps.googleusercontent.com"
    }

  },
  

  
  
};

export default config; 
