<template>
    <my-template>
        <template #content>
            <ion-toolbar>
                <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar>
                <ion-title>Mes camions</ion-title>
            </ion-toolbar>
           <ion-content>
               <div class="container">
                  
            </div>
            
            <list-paginated url="/api/camions">
                <template v-slot:list_content = camions>
                    <ion-list v-for="camion in camions.datas" :key="camion.id">
                        <ion-item>
                          <div @click="openMap(camion)" class="btn">
                            <div class="d-flex align-items-center row">
                                <div class="col-3">
                                    <img :src="camion.photo" class="w-100 rounded-circle">
                                </div>
                                <div class="col-6">
                                    <small v-if="camion.modele !== undefined">{{ camion.modele.libelle }}</small><br>
                                    <span class="font-weight-bold ">{{ camion.plaque }}</span> <br>
                                </div>
                                <div class="col-">
                                    <span v-if="camion.statut == 'Disponible'" class="badge badge-success p-2 rounded-pill">
                                        {{ camion.statut }}
                                    </span>
                                    <span v-else-if="camion.statut == 'En course'" class="badge badge-primary p-2 rounded-pill">
                                        {{ camion.statut }}
                                    </span>
                                    <span v-else class="badge badge-warning p-2 rounded-pill">
                                        {{ camion.statut }}
                                    </span>
                                </div>
                              </div>
                          </div>
                          
                        </ion-item>
                    </ion-list>
                </template>
            </list-paginated>
           </ion-content>

           <ion-modal :is-open="map">
            <ion-header>
                <ion-toolbar color="primary" id="toolbar">
                  <ion-buttons slot="end">
                    <ion-button @click="closeMap()" :strong="true">x</ion-button>
                  </ion-buttons>
                </ion-toolbar>
            </ion-header>
            <ion-content>
                <CamionShow :data="camion"></CamionShow>
            </ion-content>
           </ion-modal>

           <a class="float" @click="openModalCreate()">
            <i class="fab fa-add my-float"></i>
            <ion-fab>
              <ion-fab-button style="margin-top: 800%;">
              </ion-fab-button>
            </ion-fab>
          </a>

          <!-- creation de camion -->
          <ion-modal :is-open="form_create">
            <ion-header>
                <ion-toolbar color="primary" id="toolbar">
                  <ion-buttons slot="end">
                    <ion-button @click="closeModalCreate()" :strong="true"><span class="badge badge-secondary mx-2">x</span>fermer</ion-button>
                  </ion-buttons>
                </ion-toolbar>
            </ion-header>
            <ion-content>
                <CamionCreate></CamionCreate>
            </ion-content>
          </ion-modal>
        </template>
        
    </my-template>

   
</template>
  
<script lang="ts">
import { IonSegment, IonSegmentButton, IonFab, IonFabButton, } from '@ionic/vue';
import { defineComponent, defineAsyncComponent } from 'vue';
import { add } from 'ionicons/icons';
import 'leaflet/dist/leaflet.css';
import 'leaflet-control-geocoder';
import { toastController } from '@ionic/vue';
import CamionShow from '@/views/camion/CamionShow.vue'
import CamionCreate from '@/views/camion/CamionCreate.vue'
import L from "leaflet";
const ShowMap = defineAsyncComponent(() => import('./CamionShow.vue'));

export default defineComponent({
    components: {IonSegment, IonSegmentButton, IonFab, IonFabButton, CamionShow, CamionCreate},
    data() {
        return {
            attente: false,
            add,
            camion: [],
            map: false,
            form_create: false
        };
    },
    mounted(){
        this.getCamion()
    },
  
    methods: {
        async connectToast(position, mess) {
      const toast = await toastController.create({
        message: mess,
        duration: 2000,
        position: position,
        color: 'success'
      });

      await toast.present();
    },
    async presentToast(position, mess) {
      const toast = await toastController.create({
        message: mess,
        duration: 2000,
        position: position,
        color: 'danger'
      });

      await toast.present();
    },
        openMap(data) {
           this.map = true
           this.camion = data
        },
        closeMap() {
           this.map = false
        },
        openModalCreate(){
            this.form_create = true
        },
        closeModalCreate(){
            this.form_create = false
        },
        getCamion(){
            this.axios.get('/api/camions').then((response) => {
                console.log('camions = ', response.data)
            })
        }
    }
});
</script>