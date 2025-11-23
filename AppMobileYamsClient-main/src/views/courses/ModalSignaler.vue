<template>
    <ion-modal :is-open="isOpen" @didDismiss="closeModal" class="fullscreen-modal">
        <template v-if="this.course">
            <ion-header>
                <ion-toolbar>
                    <ion-title>COURSE {{ this.course.code }}</ion-title>
                    <ion-buttons slot="end">
                        <ion-button :strong="true" @click="closeModal()">
                            <i class="fa-solid fa-close" style="font-size: 1.4rem;"></i>
                        </ion-button>
                    </ion-buttons>
                </ion-toolbar>
            </ion-header>
            <ion-content class="ion-padding">
                <h3 class="text-center">
                    Signaler un probleme sur cette course
                </h3>
                
                <form @submit.prevent="createLine()">
                    <div class="form-group">
                        <textarea rows="10" class="form-control" v-model="form.content" placeholder="Tapez votre text ici"></textarea>
                    </div>
                    <button class="btn btn-primary btn-block">
                        <i class="fa-solid fa-envelope"></i> Envoyer
                    <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status"
                        aria-hidden="true"></span>
                        
                    </button>
                </form>

               

            </ion-content>
        </template>
    </ion-modal>


</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';

export default defineComponent({
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
            isLoading: false,
            form: {
                course_id: this.course.id
            },
            baseUrl: this.$store.state.api_yams_livraisons
        };
    },
    methods: {
        async presentToast(position: 'top' | 'middle' | 'bottom', msg, duration, color) {
            const toast = await toastController.create({
                message: msg,
                duration: duration,
                position: position,
                color: color
            });

            await toast.present();
        },
        closeModal() {
            this.$emit('close');
        },
        createLine() {
            this.isLoading = true
            this.axios.post(this.baseUrl + '/api/signalements', this.form).then(response => {
                this.isLoading = false
                if (response.data.success === true) {
                    this.resetForm()
                    this.presentToast('top', response.data.message, 3000, 'success')
                    this.$router.push({ name: 'chat.index' })
                    window.location.replace('/chat')
                }
                else {
                    this.presentToast('top', response.data.errors[0], 5000, 'danger')
                }
            }).catch(() => {
                this.isLoading = false
                this.presentToast('top', 'Erreur de connexion', 5000, 'danger')
            })
        },
        resetForm() {
            this.form = {
                course_id: this.course.id
            }
        }
    },
});
</script>
