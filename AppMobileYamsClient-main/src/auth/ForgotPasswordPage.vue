<template>
    <ion-page>
        <ion-content :fullscreen="true">
            <div class="pt-5">
                <div class="col-md-4 mx-auto">
                    <div class="text-center">
                        <div class="text-center pt-3">
                            <img src="/src/assets/logo1.png" height="100" alt="Logo" loading="lazy" />
                        </div>
                        <h2 class="text-center mb-1 text-primary pb-3">Mot de Passe Oublié</h2>
                    </div>
                    <form @submit.prevent="sendResetLink()" class="py-3">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                            </div>
                            <input placeholder="Email" type="email" class="form-control form-control-lg"
                                v-model="form.email" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-block btn-primary my-3" :disabled="isLoading">
                                Envoyer le lien de réinitialisation
                                <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </ion-content>
    </ion-page>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { IonContent, IonPage, toastController } from '@ionic/vue';
import axios from 'axios';

export default defineComponent({
    name: 'ForgotPasswordPage',
    components: { IonContent, IonPage },
    data() {
        return {
            isLoading: false,
            form: {
                email: ''
            }
        }
    },
    methods: {
      async sendResetLink() {
            this.isLoading = true;
            try {
                const response = await axios.post('/api/forgot-password', this.form);
                if (response.data.success) {
                    this.presentToast('top', response.data.message, 3000, 'success');
                    this.$router.push({ name: 'login' });
                } else {
                    this.presentToast('top', response.data.errors[0], 5000, 'danger');
                }
            } catch (error) {
                this.presentToast('top', 'Erreur lors de l\'envoi du lien de réinitialisation', 5000, 'danger');
            } finally {
                this.isLoading = false;
            }
        },
        async presentToast(position: 'top' | 'middle' | 'bottom', msg, duration, color) {
            const toast = await toastController.create({
                message: msg,
                duration: duration,
                position: position,
                color: color
            });
            await toast.present();
        },
    }
})
</script>
