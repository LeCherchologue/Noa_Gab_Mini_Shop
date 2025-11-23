<template>
    <ion-header>
      <ion-toolbar>
        <ion-buttons slot="end">
          <ion-button @click="confirm" :strong="true">x</ion-button>
        </ion-buttons>
      </ion-toolbar>
    </ion-header>
    <ion-content>
        <h5 class="mb-3 text-center font-weight-bold">Annonces #{{ annonces.id }}</h5>
        <div>
            <ion-card style="width: 180px; margin-left: 110px;" >
                <ion-card-content> 
                   <h2 class="text-center"> {{ annonces.adresse_chargement }} </h2>
                    <h2 class="text-center">{{ annonces.adresse_dechargement }}</h2>
                </ion-card-content>
                
                
            </ion-card>
        </div>
        <div class="container">
            <form>
                <div class="form-group ">
                    <label>Marchandise</label>
                    <input type="text" v-model="type_marchandise" class="form-control" disabled>
                </div>
                <div class="form-group ">
                    <label>Type de course</label>
                    <input type="text" class="form-control" disabled>
                </div>
                <div class="form-group ">
                    <label>Budget</label>
                    <input type="text" class="form-control" v-model="montant" disabled>
                </div>
                
                <button type="submit" class="btn btn-primary mt-4" >
                <span v-if="this.$store.state.isLoading === true" class="spinner-border spinner-border-sm" role="status"
                    aria-hidden="true"></span>
                Postuler
                </button>
            </form>
          </div>
    </ion-content>
  </template>
  
  <script lang="ts" setup>
    import {
      IonContent,
      IonHeader,
      IonTitle,
      IonToolbar,
      IonButtons,
      IonButton,
      modalController,
    } from '@ionic/vue';
    import { defineComponent, ref, onMounted, defineProps } from 'vue';
    import { toastController } from '@ionic/vue';
    import axios from 'axios'
    import store from '../../store'
    const name = ref();
    const { annonces } = defineProps(['annonces']);
    const type_marchandise = annonces.type_marchandise
    const montant = annonces.trajet.montant
    console.log('test id = ', store.getters.user.id)
    const cancel = () => modalController.dismiss(null, 'cancel');
    const confirm = () => modalController.dismiss(name.value, 'confirm');
    const form = {
        annonce_id: annonces.id,
        user_id: store.getters.user.id,
    }

    const connectToast = async (position, mess) =>{
        const toast = await toastController.create({
        message: mess,
        duration: 2000,
        position: position,
        color: 'success'
      });

      await toast.present();
    }

    const presentToast = async (position, mess) =>{
        const toast = await toastController.create({
        message: mess,
        duration: 2000,
        position: position,
        color: 'danger'
      });

      await toast.present();
    }
    const Postuler = () =>{
        axios.post('/api/annonce_user', form).then((response) => {

        console.log('mess = ', response.data.success)
        if (response.data.success === true) {
       
        connectToast('top', response.data.message)
        }
        else {
            presentToast('top', response.data.errors[0])
        }
     
        })
    }
  </script>



  <style>

  #map {
    height: 400px;
    width: 100%;
    padding: 0 !important;
}

</style>
