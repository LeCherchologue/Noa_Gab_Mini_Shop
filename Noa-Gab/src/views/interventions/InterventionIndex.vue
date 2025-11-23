<template>
    <my-template>
      <template v-slot:content>
        <div class="container">
            <h5 class="mb-3">Interventions</h5>
            <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar>
            <list-paginated url="/api/interventions">
                <template v-slot:list_content = interventions>
                    <ul v-for="intervention in interventions.datas" :key="intervention.id" class="list-group list-group-flush" @click="openModal(intervention)">
                        <li v-if="intervention.camion.plaque && intervention.camion" class="list-group-item d-flex justify-content-between align-items-center">
                          <div>
                              <span class="font-weight-bold ">{{ intervention.camion.plaque }}</span><br>
                              <h6>{{ intervention.garage.nom }} - {{ intervention.garage.ville }}</h6>
                              <small class="font-italic ">{{ dateMoment(intervention.debut) }} au {{ dateMoment(intervention.fin) }}</small>
                          </div>
                          <div>
                            <button class="badge badge-warning p-2 rounded-pill">
                                {{ intervention.type }}
                            </button>
                          </div>
                        </li>
                      </ul>
                </template>
            </list-paginated>     
        </div>
      </template>
    </my-template>
  </template>
  
  <script lang="ts">
import { defineComponent, defineAsyncComponent } from 'vue';
import { IonBadge} from '@ionic/vue';
import moment from 'moment';
const InterventionShow = defineAsyncComponent(() => import('./InterventionShow.vue'));

export default defineComponent({
    components: { IonBadge },
    data() {
        return {
            isLoading: true,
            interventions: [],
            first: 0,
            rows: 8,
        };
    },

    mounted(){
        this.getInterventions()
    },
    methods: {
        dateMoment(dates){
            return moment(dates).format('DD-MM-YYYY')
        },
        getInterventions() {
            this.axios.get('/api/interventions').then((response) => {
                this.isLoading = false
                this.interventions = response.data
                console.log('interventions = ', this.interventions)
            }).catch(() => {
                this.isLoading = false
            })
        },

        openModal(intervention) {
        this.$dialog.open(InterventionShow, {
            props: {

                style: {
                    'background-color': 'white',
                    'border-radius': '10px',
                    'box-shadow':'10px 5px 5px gray',
                    width: '90vw'
                },
                modal: true
            },
            data: intervention
        });
    },
    }
});
</script>