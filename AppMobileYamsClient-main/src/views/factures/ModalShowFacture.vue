<template>
    <ion-modal :is-open="isOpen" @didDismiss="closeModal" class="fullscreen-modal">
        <template v-if="this.course">
            <ion-header>
                <ion-toolbar>
                    <ion-title>DETAILS FACTURE {{ this.course.id }}</ion-title>
                    <ion-buttons slot="end">
                        <ion-button :strong="true" @click="closeModal()">
                            <i class="fa-solid fa-close" style="font-size: 1.4rem;"></i>
                        </ion-button>
                    </ion-buttons>
                </ion-toolbar>
            </ion-header>
            <ion-content class="ion-padding">
                <p><strong>Course :</strong> {{ this.course.code }}</p>
                <p><strong>Trajet :</strong> {{ this.course.adresse_chargement }} ({{ formatDate(this.course.date_chargement) }}) - {{ this.course.adresse_dechargement }} ({{ formatDate(this.course.date_dechargement) }})</p>
                <p><strong>Montant:</strong> {{ formatPriceWithDevise(this.course.trajet.montant) }}</p>

                <ExportFacture :course="this.course"></ExportFacture>
                    
            </ion-content>
        </template>
    </ion-modal>


</template>

<script lang="ts">
import moment from 'moment'
import ExportFacture from "./ExportFacture.vue";
import { defineComponent } from 'vue';

export default defineComponent({
    components: {ExportFacture},
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
            // 
        };
    },
    methods: {
        formatDate(val) {
            if (val) return moment(String(val)).format('DD/MM/YYYY')
        },
        formatPriceWithDevise(val) {
            if (val) return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'XAF' }).format(val)
        },
        closeModal() {
            this.$emit('close');
        }
    }
});
</script>