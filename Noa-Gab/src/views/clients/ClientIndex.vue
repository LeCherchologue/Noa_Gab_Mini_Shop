<template>

    <my-template>
        <template #content>
            <ion-toolbar>
                <ProgressBar v-if="isLoading === true" mode="indeterminate" style="height: 6px"></ProgressBar>
                <ion-title>Les clients</ion-title>
            </ion-toolbar>
            
            <list-paginated url="/api/users?type=client">
                <template v-slot:list_content = users>
                    <ion-list v-for="user in users.datas" :key="user.id">
                        <ion-item>
                            <div class="btn">
                                <div class="d-flex align-items-center row">
                                    <div class="col-3">
                                        <img :src="user.photo" class="w-100 rounded-circle">
                                    </div>
                                    <div class="col-6">
                                        <span class="font-weight-bold ">{{ user.nom}} - {{ user.prenom }}</span><br>
                                        <small class="font-italic ">{{ user.telephones }}</small>
                                    </div>
                                    <div class="col-3">
                                        
                                    </div>
                                  </div>
                              </div>
                          
                        </ion-item>
                    </ion-list>
                </template>
            </list-paginated>

            <a class="float" @click="openModalClient()">
                <i class="fab fa-add my-float"></i>
                <ion-fab>
                  <ion-fab-button style="margin-top: 800%;">
                  </ion-fab-button>
                </ion-fab>
              </a>

              <ion-modal :is-open="clientModal">
                <ion-header>
                    <ion-toolbar color="primary">
                      <ion-buttons slot="end">
                        <ion-button @click="closeModalClient()" :strong="true">x</ion-button>
                      </ion-buttons>
                    </ion-toolbar>
                  </ion-header>
                <ion-content>
                    <ClientCreate></ClientCreate>
                </ion-content>
              </ion-modal>
        </template>
        
    </my-template>
</template>
  
<script lang="js">
import { IonSegment, IonSegmentButton, IonFab, IonFabButton, } from '@ionic/vue';
import { defineComponent, defineAsyncComponent } from 'vue';
import ClientCreate from '@/views/clients/ClientCreate.vue'
export default defineComponent({
    components: {IonSegment, IonSegmentButton, IonFab, IonFabButton, ClientCreate},
    data() {
        return {
            attente: false,
            clientModal: false
        };
    },
    mounted(){
        this.openMap()
    },
    methods: {
        openMap() {
            this.axios.get('/api/users?type=client').then((response) => {
            console.log('users = ', response.data)
        })
        
        },
        openModalClient(){
            this.clientModal = true
        },
        closeModalClient(){
            this.clientModal = false
        }
    }
});
</script>