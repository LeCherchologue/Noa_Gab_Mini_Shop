<template>
    <ion-header>
      <ion-toolbar color="primary">
        <ion-title>CALENDRIER</ion-title>
        <ion-buttons slot="end">
          <ion-button @click="confirm" :strong="true">x</ion-button>
        </ion-buttons>
      </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
        <div>
            <div class="header-contentys pt-3 d-flex align-items-center">
            </div>
    
            <div class="body-contentys ">
               
                <FullCalendar :options='calendarOptions'>
                    <template v-slot:eventContent='arg'>
                        <small href="#" class="btn text-wrap text-white" @click.prevent="showEvent(arg.event.extendedProps)">{{ arg.event.title
                        }}</small>
                    </template>
                </FullCalendar>
            </div>
        </div>
        <div>

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
import {  ref, onMounted, defineProps } from 'vue';

const name = ref();

const confirm = () => modalController.dismiss(name.value, 'confirm');
</script>

<script lang="ts">
import moment from 'moment'
import { defineComponent } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import bootstrapPlugin from '@fullcalendar/bootstrap';


export default defineComponent({
    components: { FullCalendar },
    data() {
        return {
            isLoading: false,
            lastID: 1,
            calendarOptions: {
                plugins: [dayGridPlugin, bootstrapPlugin],
                themeSystem: 'bootstrap',
                initialView: 'dayGridMonth',
                events: [],
                locale: 'fr',
                height: '500px',
                datesSet: this.handleMonthChange,
                eventClassNames: 'custom-event-card',
                headerToolbar:{
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridDay,dayGridMonth'
                }
            },
            moisPlay: null
        }
    },
    mounted() {
        this.refreshDatas(moment().format('YYYY-MM'))
    },
    methods: {
        handleMonthChange(payload) {
            const newDate = payload.view.currentStart
            const mois = newDate.getMonth() + 1
            const annee = newDate.getFullYear()
            this.refreshDatas(moment().format(annee + '-' + mois))
        },
        async refreshDatas(YYYYmm) {
            await this.getCourses(YYYYmm)
        },
        getCourses(period) {
            this.isLoading = true
            this.axios.get('/api/courses?req_period=' + period).then((response) => {
                response.data.forEach(element => {
                    this.calendarOptions.events.push({
                        title: 'Départ course ' + element.plaque + ' ' + element.adresse_chargement + ' - ' + element.adresse_dechargement,
                        date: element.date_chargement,
                        color: 'blue',
                        extendedProps: {
                            id: element.id,
                            table: 'courses',
                            data: element
                        },
                        id: this.lastID++
                    })
                    if (element.date_dechargement) {
                        this.calendarOptions.events.push({
                            title: 'Arrivée course ' + element.plaque + ' ' + element.adresse_chargement + ' - ' + element.adresse_dechargement,
                            date: element.date_dechargement,
                            color: 'green',
                            extendedProps: {
                                id: element.id,
                                table: 'courses',
                                data: element
                            },
                            id: this.lastID++
                        })
                    }
                });
                this.isLoading = false
            }).catch(() => {
                this.isLoading = false
                this.$toast.add({
                    severity: 'error',
                    summary: 'Probleme de connexion',
                    detail: 'Une erreur s\'est produite lors de la connexion au serveur !',
                    life: 5000
                });
            })
        },
    
    }
})
</script>

  <style>

  #map {
    height: 400px;
    width: 100%;
    padding: 0 !important;
}

.custom-event-card{
    width: 100%;
}

</style>

