<template>
    <ion-header>
      <ion-toolbar>
        <ion-buttons slot="end">
          <ion-button @click="confirm" :strong="true">x</ion-button>
        </ion-buttons>
      </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
      <ion-title class="text-center font-weight-bold">COURSE</ion-title>
      <p class="mt-3 text-center">Veuillez téléverser les documents de livraison pour confirmer la fermeture</p><br>

      <div class="mt-3">
        <form action="">
            <div>
                <small class="ion-padding">Bordereau de livraison signé</small>
                <div class="d-flex">
                    <div class="col-6">
                        <input type="text" class="form-control">
                    </div>
                    <div>
                        <input type="file" class="form-control">
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <small class="ion-padding">Bordereau de douane</small>
                <div class="d-flex">
                    <div class="col-6">
                        <input type="text" class="form-control">
                    </div>
                    <div>
                        <input type="file" class="form-control">
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <small class="ion-padding">Autres</small>
                <div class="d-flex">
                    <div class="col-6">
                        <input type="text" class="form-control">
                    </div>
                    <div>
                        <input type="file" class="form-control">
                    </div>
                </div>
            </div>
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
    import {ref} from 'vue';
   
    const name = ref();

    const confirm = () => modalController.dismiss(name.value, 'confirm');
  </script>

