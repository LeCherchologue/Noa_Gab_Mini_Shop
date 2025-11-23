<template>
    <ion-page>
        <ion-content :fullscreen="true">
            <div class="pt-5">
                <div class="col-md-4 mx-auto">
                    <div class="text-center ">
                        <div class="text-center pt-3">
                            <img src="/src/assets/logo1.png" height="100" alt="Logo" loading="lazy" />
                        </div>
                        <h2 class="text-center mb-1 text-primary pb-3">VERIFICATION DU COMPTE</h2>
                        <p>consultez votre adresse mail pour identifier votre code de vérification </p>
                    </div>
                    <span v-if="resendCodeIsLoading == true" class="spinner-border mx-auto" role="status" aria-hidden="true"></span>
                    <form v-else @submit.prevent="verify()" class="py-3">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                            </div>
                            <input placeholder="Code de vérification" type="text" class="form-control form-control-lg" v-model="form.code" required>
                        </div>

                        

                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-block btn-primary my-3" :disabled="isLoading">
                                verifier
                                <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                            <a href="#renvoyer-le-code" class="btn btn-link" @click.prevent="resendCode()">
                                  vous n'avez pas reçu le code ? renvoyer
                            </a>
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

export default defineComponent({
    name: 'LoginPage',
    components: { IonContent, IonPage },
    data() {
        return {
            isLoading: false,
            resendCodeIsLoading: false,
            mess: '',
            status: '',
            form: {
                code: '',
                userId:  this.$store.state.user.id
                
            }
        }
    },
    mounted(){
         console.log("user",localStorage.getItem("yams_user_session"))
    },
    methods: {
        resendCode(){
            this.resendCodeIsLoading = true
            this.axios.post('/api/send-verification-code', this.form).then(response => {
                if (response.data.success === true) {
                    this.presentToast('top', response.data.message, 3000, 'success')
                }
                else {
                    this.presentToast('top', response.data.errors[0], 5000, 'danger')
                }
                this.resendCodeIsLoading = false
            }).catch(() => {
                this.resendCodeIsLoading = false
                this.presentToast('top', 'Erreur de connexion', 5000, 'danger')
            })
        },
        verify() {
            this.isLoading = true
            this.axios.post('/api/verify-account', this.form).then(response => {
                if (response.data.success === true) {
                    this.$store.commit('setVerifiedAccount', true)
                    this.$router.push({ name: 'home' })
                    this.resetForm()
                    this.presentToast('top', response.data.message, 3000, 'success')
                }
                else {
                    this.presentToast('top', response.data.errors[0], 5000, 'danger')
                }
                this.isLoading = false
            }).catch(() => {
                this.isLoading = false
                this.presentToast('top', 'Erreur de connexion', 5000, 'danger')
            })
        },
        resetForm() {
            this.form = {
                code: '',
                userId: this.$store.state.user.id
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