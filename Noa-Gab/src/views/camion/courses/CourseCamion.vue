<template>
    <my-template>
        <template #content>
            <ion-toolbar>
                
                <ion-title>Courses</ion-title>
                
                <form action="" class="ion-padding">
                    <div class="form-group">
                        <select class="form-control" v-model="searchValue">
                            <option v-for="camion in camions" :value="camion.id" :key="camion.id">{{ camion.plaque }}</option>
                        </select>
                    </div>
                </form>
            </ion-toolbar>
            <ion-content>
                <div v-if="isLoading">
                    <div class="overlay" >
                      <div class="overlay__inner">
                        <div class="overlay__content">
                          <span class="spinner"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                <ion-list v-for="course in filtrePlaque" :key="course.id">
                
                <ion-item v-if="course.camion.chauffeur_principal && course.camion">
                  <div class="btn">
                    <div class="d-flex align-items-center row">
                        <div class="col-3">
                            <img :src="course.camion.chauffeur_principal.photo" class="w-100 rounded-circle">
                        </div>
                        <div class="col-6">
                            <small>Trajet</small> <br>
                            <span class="font-weight-bold ">{{ course.adresse_chargement }} à {{ course.adresse_dechargement }}</span><br>
                            <small class="font-italic ">{{ course.date_chargement }} / {{ course.date_dechargement }}</small>
                        </div>
                        <div class="col-3">
                            <lottie-player v-if="course.etat == 'En cours'" autoplay loop mode="normal" style="width: 100%" src="/json/truck_yams.json"></lottie-player>
                            <i v-else class="fa-solid fa-circle-check"></i>
                        </div>
                      </div>
                  </div>
                  
                </ion-item>
            </ion-list>
           </ion-content>
        </template>
        
    </my-template>
</template>
  
<script lang="ts">
import { IonSegment, IonSegmentButton, IonFab, IonFabButton, } from '@ionic/vue';
import { defineComponent, defineAsyncComponent } from 'vue';
const CourseShow = defineAsyncComponent(() => import('../../courses/CourseShow.vue'));
const CourseShowTerminer = defineAsyncComponent(() => import('../../courses/CourseTerminer.vue'));
export default defineComponent({
    components: {IonSegment, IonSegmentButton, IonFab, IonFabButton},
    data() {
        return {
            first: 0,
            rows: 8,
            attente: false,
            coursesFiltered: [],
            coursesDemandes: [],
            courses: [],
            camions: [],
            camion_id: 0,
            searchValue: '',
            isLoading: true
        };
    },
    computed: {
        filtrePlaque() {
            return this.courses.filter((course) => {
                const camion = course.camion;
                return camion && camion.plaque.includes(this.searchValue);
            });
        },

    },
    mounted(){
       this.getCamions()
       this.getCourses()
    },
    methods: {
        getCourses(){
            this.axios.get('/api/courses?camion_id=' + this.$route.params.id).then((response) => {
                this.courses = response.data
                console.log('course = ', response.data)
                this.isLoading = false
            }).catch(() => {
            })   
        },
        getCamions(){
            this.axios.get('/api/camions').then((response) => {
                this.camions = response.data
                this.isLoading = false
            }).catch(() => {
            })   
        },
        // goMap(course, camion){
        //     if (course.etat == 'En cours') {
        //         this.openMap(camion)
        //     }
        //     else{
        //         this.openMapTerminer(course)
        //     }
        // },
       
        FilterCourses (datas) {
           return datas.filter(item => item.etat == this.tab)
        },
        // openMap(course) {
        //     this.$dialog.open(CourseShow, {
        //         props: {
        //             header: course.plaque,
        //             style: {
        //                 width: '90vw'
        //             },
        //             modal: true
        //         },
        //         data: course
        //     });
        // },
        // openMapTerminer(course) {
        //     this.$dialog.open(CourseShowTerminer, {
        //         props: {
        //             header: course.camion.plaque,
        //             style: {
        //                 width: '100vw',
        //                 height: '100%'
        //             },
        //             modal: true
        //         },
        //         data: course
        //     });
        // }
    }
});
</script>