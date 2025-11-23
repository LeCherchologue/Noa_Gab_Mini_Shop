<template>
    <div class="container">
        <form @submit.prevent="createLine()">
            <div class="form-row">
                <div class="form-group col-6">
                    <label>Nom<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="form.nom" required>
                </div>
                <div class="form-group col-6">
                    <label>Prénom<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" v-model="form.prenom">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-6">
                    <label>Téléphone 1<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="form.telephone1">
                </div>
                <div class="form-group col-6">
                    <label>Téléphone 2</label>
                    <input class="form-control" type="text" v-model="form.telephone2">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-6">
                    <label>Email</label>
                    <input class="form-control" type="email" v-model="form.email">
                </div>
                <div class="form-group col-6">
                    <label>Adresse</label>
                    <input type="text" class="form-control" v-model="form.adresse">
                </div>
                <div class="form-group col-6">
                    <label>Boite Postale</label>
                    <input type="text" class="form-control" v-model="form.bp">
                </div>
            </div>

            <div class="form-group mb-3">
                <label> Note </label>
                
                <textarea class="form-control" v-model="form.description"  name="" id="" cols="30" rows="10"></textarea>
            </div>

            <div class="form-group mb-3">
                <label>Commercial </label>
                <select class="form-control" v-model="form.commercial_id">
                    <option v-for="line in commercials" :key="line.id" :value="line.id">{{ line.name }}</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block" :disabled="isLoading">
                <i class="fa-solid fa-save"></i> Enregistrer
                <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
        </form>
      </div>
</template>


<script >
import { toastController } from '@ionic/vue';
export default {
    components: {toastController},
    name: 'ClientCreate',
    inject: ['dialogRef'],
    data() {
        return {
            isLoading: true,
            table: 'clients',
            commercials: [],
            form: {
                name: '',
                nom: '',
                prenom: '',
                telephone1: '',
                telephone2: '',
                adresse: '',
                email: '',
                type: 'client',
                description: '',
                commercial_id: '',
                bp: ''
            }
        }
    },
    mounted() {
        this.getCommercials()
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
        getCommercials() {
            this.isLoading = true
            this.axios.get('/api/users?type_user=employe&poste_user=commercial').then((response) => {
                this.commercials = response.data
                this.isLoading = false
            }).catch(() => {
                this.isLoading = false
                this.$toast.add({
                    severity: 'error',
                    summary: 'Probleme de connexion',
                    detail: 'Une erreur s\'est produite lors de la connexion au serveur !',
                    life: 5000
                });
            })
        },
        createLine() {
            this.isLoading = true
            this.axios.post('/api/users', this.form).then((response) => {
                this.isLoading = false
                if (response.data.success === true) {
                    this.connectToast('top', response.data.message)
                    this.resetForm()
                }
                else {
                    this.presentToast('top', response.data.errors[0])
                }
            })
        },
        resetForm() {
            this.form = {
                name: '',
                nom: '',
                prenom: '',
                telephone1: '',
                telephone2: '',
                adresse: '',
                email: '',
                type: 'client',
                description: '',
                commercial_id: '',
                bp: ''
            }
        }
    }
}
</script>