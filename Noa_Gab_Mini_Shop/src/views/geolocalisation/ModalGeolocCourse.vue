<template>
    <ion-modal :is-open="isOpen" @didDismiss="closeModal" class="fullscreen-modal" @ionModalDidPresent="modalPresented">
        <template v-if="this.course">
            <ion-header>
                <ion-toolbar>
                    <ion-title>Course {{ this.course.code }}</ion-title>
                    <ion-buttons slot="end">
                        <ion-button :strong="true" @click="closeModal()">
                            <i class="fa-solid fa-close" style="font-size: 1.4rem;"></i>
                        </ion-button>
                    </ion-buttons>
                </ion-toolbar>
            </ion-header>
            <ion-content class="ion-padding">
                <div v-if="isMapReady">
                    <MapView v-if="this.course.etat == 'En cours'" :deviceId="this.course.vehicule_deviceId" location="actual"></MapView>
                    <MapView v-else :deviceId="this.course.vehicule_deviceId" location="history" :course="this.course"></MapView>
                </div>
            </ion-content>
        </template>
    </ion-modal>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import MapView from './MapView.vue';

export default defineComponent({
    components: { MapView },
    props: {
        isOpen: {
            type: Boolean,
            required: true
        },
        course: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            isMapReady: false,
        };
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        modalPresented() {
            this.isMapReady = true;
        }
    }
});
</script>

<style scoped>
ion-content {
  --padding-start: 0;
  --padding-end: 0;
  --padding-top: 0;
  --padding-bottom: 0;
}
</style>