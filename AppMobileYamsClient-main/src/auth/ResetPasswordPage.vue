<template>
    <ion-page>
        <ion-content :fullscreen="true">
            <div class="pt-5">
                <div class="col-md-4 mx-auto">
                    <div class="text-center">
                        <div class="text-center pt-3">
                            <img src="/src/assets/logo1.png" height="100" alt="Logo" loading="lazy" />
                        </div>
                        <h2 class="text-center mb-1 text-primary pb-3">Réinitialiser le Mot de Passe</h2>
                    </div>
                    <form @submit.prevent="resetPassword()" class="py-3">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                            </div>
                            <input placeholder="Nouveau Mot de Passe" type="password" class="form-control form-control-lg"
                                v-model="form.password" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                            </div>
                            <input placeholder="Confirmer le Mot de Passe" type="password" class="form-control form-control-lg"
                                v-model="form.password_confirmation" required>
                        </div>
                        <input type="hidden" v-model="token" />
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-block btn-primary my-3" :disabled="isLoading">
                                Réinitialiser le Mot de Passe
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
import { useRoute } from 'vue-router';

export default defineComponent({
    name: 'ResetPasswordPage',
    components: { IonContent, IonPage },
    data() {
        return {
            isLoading: false,
            token: '',
            form: {
                password: '',
                password_confirmation: ''
            }
        }
    },
    setup() {
        const route = useRoute();
        return { route };
    },
    mounted() {
        this.token = this.route.query.token as string;
    },
    methods: {
        async resetPassword() {
            this.isLoading = true;
            try {
                const response = await this.axios.post('/api/reset-password', {
                    ...this.form,
                    token: this.token
                });
                if (response.data.success) {
                    this.presentToast('top', response.data.message, 3000, 'success');
                    this.$router.push({ name: 'login' });
                } else {
                    this.presentToast('top', response.data.errors[0], 5000, 'danger');
                }
            } catch (error) {
                this.presentToast('top', 'Erreur lors de la réinitialisation du mot de passe', 5000, 'danger');
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
