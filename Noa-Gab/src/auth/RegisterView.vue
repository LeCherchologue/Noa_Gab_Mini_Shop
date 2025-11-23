<template>
    <div id="topbar">
        <div class="d-flex justify-content-between m-2 align-items-center">
           
            <div>
                <router-link to="/">
                    <img src="/src/assets/yams.png" style="width: 70px; margin-left: 155px;">
                </router-link>
            </div>
        </div>
    </div>
    <ion-content>
        <div class="ion-padding mt-2">
            <form @submit.prevent="register()">
                <div class="form-group ">
                    <label>Noms</label>
                    <input type="text"  class="form-control" v-model="form.nom">
                </div>
                <div class="form-group ">
                    <label>Prénom</label>
                    <input type="text" class="form-control" v-model="form.prenom">
                </div>
                <div class="form-group ">
                    <label>Date de naissance</label>
                    <input type="date" class="form-control" v-model="form.date_naissance">
                </div>
                <div class="form-group ">
                    <label>Telephone</label>
                    <input type="text" class="form-control" v-model="form.telephone1">
                </div>
                <div class="form-group ">
                    <label>Email</label>
                    <input class="form-control" type="email" v-model="form.email">
                </div>
                <div class="form-group ">
                    <label>Mot de passe</label>
                    <input type="password" class="form-control" v-model="form.password">
                </div>
                <div class="form-group ">
                    <label>Confirmation du mot de passe</label>
                    <input type="password" class="form-control" v-model="form.password_confirmation">
                </div>
                <div class="d-flex justify-content-between">
                    <a type="submit" class="btn btn-secondary mt-4" href="/">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary mt-4">
                        <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status"
                        aria-hidden="true"></span>
                        Enregistrer
                    </button>
                </div>
            </form>
    
        </div>
    </ion-content>
</template>



<script>
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';

export default defineComponent({
    components: [toastController],
    data() {
        return {
            isLoading: false,
            step: 1,
            form: {
                nom: '',
                prenom: '',
                date_naissance: '',
                telephone: '',
                email: '',
                password: '',
                password_confirmation: '',
            }
        }
    },
    methods: {
        async connectToast(position, mess) {
            const toast = await toastController.create({
                message: mess,
                duration: 2000,
                position: position,
                color: 'success'
            });

            await toast.present();
        },
        async presentToast(position, mess) {
        const toast = await toastController.create({
            message: mess,
            duration: 2000,
            position: position,
            color: 'danger'
        });

        await toast.present();
        },
        register(){
            this.isLoading = true
            this.axios.post('/api/register', this.form).then((response) => {

                console.log('register = ', response.data)
                if (response.data.success == true) {
                    this.resetForm()
                    this.connectToast('top', response.data.message)
                }
                else {
                    
                    this.presentToast('top', response.data.errors[0])
                }
                this.isLoading = false
            }).catch(() => {
                this.isLoading = false
            })
        },
        resetForm() {
            this.form = {
                nom: '',
                prenom: '',
                date_naissance: '',
                telephone1: '',
                email: '',
                password: '',
                password_confirmation: '',
            }
        }
       
    }
})
</script>