<template>
    <ion-modal :is-open="isOpen" @didDismiss="closeModal" class="fullscreen-modal">
        <template v-if="this.notification">
            <ion-header>
                <ion-toolbar>
                    <ion-title>{{ this.notification.data.libelle }}</ion-title>
                    <ion-buttons slot="end">
                        <ion-button :strong="true" @click="closeModal()">
                            <i class="fa-solid fa-close" style="font-size: 1.4rem;"></i>
                        </ion-button>
                    </ion-buttons>
                </ion-toolbar>
            </ion-header>
            <ion-content class="ion-padding">
             <div class="modal-body">
              <h5>{{ notification.data.user_name }} a {{ notification.data.libelle }}</h5>
              <p>{{ notification.data.description }}</p>
             <small>{{ notification.created_at }}</small>
            </div>

            </ion-content>
        </template>
    </ion-modal>
  
  
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  
  export default defineComponent({
  
    props: {
        isOpen: {
            type: Boolean,
            required: true
        },
        notification: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            
        };
    },
    methods: {
      closeModal() {
              this.$emit('close');
          }
    }
  });
  </script>