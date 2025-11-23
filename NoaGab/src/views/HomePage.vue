<template>
    <ion-page>
        <ion-content :fullscreen="true">
            <div class="pt-5">
                <div class="col-md-4 mx-auto">
                    <div class="text-center ">
                        <div class="text-center pt-3">
                            <!-- <img src="/src/assets/logo1.png" height="100" alt="Logo" loading="lazy" /> -->
                        </div>
                        <h2 class="text-center mb-1 text-primary pb-3">CONNEXION</h2>
                    </div>
                    <form @submit.prevent="login()" class="py-3">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                            </div>
                            <input placeholder="Email / Telephone" type="text" class="form-control form-control-lg"
                                v-model="form.email" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                            </div>
                            <input placeholder="Mot de passe" type="password" class="form-control form-control-lg"
                                v-model="form.password" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-block btn-primary my-3" :disabled="isLoading">
                                Se connecter
                                <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                            </button>

                            <!-- <button type="button" class="btn btn-lg btn-block btn-outline-primary my-3"
                                @click="signInWithGoogle">
                                <i class="fa-brands fa-google"></i> Se connecter avec Google
                            </button> -->

                            <!-- <router-link :to="{ name: 'register' }" class="btn btn-link">
                                Vous n'avez pas de compte ?
                            </router-link> -->

                            <!-- <router-link :to="{ name: 'forgot-password' }" class="btn btn-link">
                                Mot de passe oublié ?
                            </router-link> -->
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
import { mapGetters, mapActions } from 'vuex';
// import { GoogleAuth } from '@codetrix-studio/capacitor-google-auth';

export default defineComponent({
    name: 'LoginPage',
    components: { IonContent, IonPage },
    data() {
        return {
            isLoading: false,
            mess: '',
            status: '',
            form: {
                email: '',
                password: ''
            }
        }
    },
    computed: {
        ...mapGetters(['fetchInterval']),
    },
    methods: {
        ...mapActions(['fetchNotifications']),
        login() {
            this.isLoading = true
            this.axios.post('/api/login', this.form).then(response => {
                if (response.data.success === true) {
                    const user = response.data.data

                    
                    this.$store.commit('setAuthenticated', user)
                    this.$router.push({ name: 'accueil' })

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
                email: '',
                password: ''
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

        // async signInWithGoogle() {
        //     try {
        //         const googleUser = await GoogleAuth.signIn();
        //         console.log('Google User:', googleUser);

        //         // Envoyer le token Google à l'API Laravel pour l'authentification
        //         const response = await this.axios.post('/api/auth/google', {
        //             token: googleUser.authentication.idToken,
        //         });

        //         // Stocker le token JWT et rediriger l'utilisateur
        //         if (response.data.token) {
        //             localStorage.setItem('token', response.data.token);
        //             this.$router.push({ name: 'accueil' });
        //         }
        //     } catch (error) {
        //         console.error('Error during Google Sign-In:', error);
        //         this.presentToast('top', 'Erreur de connexion avec Google', 5000, 'danger');
        //     }
        // }
    }
})
</script>