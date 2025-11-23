<template>
    <form @submit.prevent="createLine()" class="ion-padding">
        <div class="form-group">
            <label>Photo</label>
            <input type="file" class="form-control" ref="file" v-on:change="onFilePhoto()">
        </div>
            
        <div class="form-row">
            <div class="form-group col-6">
                <label>Noms<span class="text-danger">*</span></label>
                <input type="text" v-model="form.nom" class="form-control" required>
            </div>
            <div class="form-group col-6">
                <label>Prenoms</label>
                <input type="text" v-model="form.prenom" class="form-control">
            </div>
            <div class="form-group col-6">
                <label>Pseudo<span class="text-danger">*</span></label>
                <input type="text" v-model="form.name" class="form-control" required>
            </div>
            <div class="form-group col-6">
                <label>Email</label>
                <input type="email" class="form-control" v-model="form.email">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label>Telephone 1<span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="form.telephone1" required>
            </div>
            <div class="form-group col-6">
                <label>Telephone 2</label>
                <input type="text" class="form-control" v-model="form.telephone2">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label>Date de naissance</label>
                <input type="date" class="form-control" v-model="form.date_naissance">
            </div>
            <div class="form-group col-6">
                <label>Sexe<span class="text-danger">*</span></label>
                <select class="form-control" v-model="form.sexe">
                    <option value="Masculin">Masculin</option>
                    <option value="Feminin">Feminin</option>
                </select>
            </div>
            <div class="form-group col-6">
                <label>Poste<span class="text-danger">*</span></label>
                <select class="form-control" v-model="form.poste" required>
                    <option value="Chauffeur">Chauffeur</option>
                    <option value="Commercial">Commercial</option>
                    <option value="Comptable">Comptable</option>
                    <option value="Informaticien">Informaticien</option>
                    <option value="Comunity-Manager">Comunity Manager</option>
                </select>
            </div>
            <div class="form-group col-6">
                <label>Adresse</label>
                <input type="text" class="form-control" v-model="form.adresse">
            </div>
        </div>

        <div class="form-row">
            
            <div class="form-group col-6">
                <label>BP</label>
                <input type="text" class="form-control" v-model="form.bp">
            </div>
            <div class="form-group col-6">
                <label>Commission %</label>
                <input type="text" class="form-control" v-model="form.commission">
            </div>
        </div>

        <div class="form-group">
            <p>
                <Strong>Permis de conduire</Strong>
            </p>
            <div v-for="permis in types_permis" :key="permis.id" class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" :value="permis" v-model="types_permis_conducteurs" :id="permis.id">
                <label class="form-check-label" :for="permis.id">{{ permis.libelle }}</label>
            </div>
        </div>
        <div class="form-group mb-3">
            <label>Note</label>
            <textarea v-model="form.description" class="form-control" name="" id="" cols="30" rows="10"></textarea>
          
        </div>

        <button type="submit" class="btn btn-primary btn-block" :disabled="isLoading">
            <i class="fa-solid fa-save"></i> Enregistrer
            <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
    </form>
</template>
<script>
import $ from "jquery";
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';
export default defineComponent({
    name: 'CreateEmploye',
    components: {toastController},
    inject: ['dialogRef'],
    data() {
        return {
            isLoading: false,
            table: 'employes',
            types_permis: [],
            form: {
                name: '',
                nom: '',
                prenom: '',
                email: '',
                type: 'employe',
                poste: '',
                telephone1: '',
                telephone2: '',
                adresse: '',
                date_naissance: '',
                description: '',
                commission: '',
                types_permis_conducteurs: []
            },
            types_permis_conducteurs: []
        }
    },
    mounted() {
        this.getTypesPermis()
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
        getPermission(permission) {
            return this.$store.getters.permissions.includes(permission)
        },
        getTypesPermis() {
            this.isLoading = true
            this.axios.get('/api/types_permis_conducteurs').then((response) => {
                this.types_permis = response.data
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
        onFilePhoto() {
            this.form.photo = this.$refs.file.files[0];
        },
        createLine() {
            this.isLoading = true
            for (let index = 0; index < this.types_permis_conducteurs.length; index++) {
                const element = this.types_permis_conducteurs[index];
                this.form.types_permis_conducteurs[index] = element.id
            }
            const config = {
                headers: { 'Content-Type': 'multipart/form-data' }
            }
            this.axios.post('/api/users', this.form, config).then(response => {
                this.isLoading = false
                if (response.data.success === true) {
                    this.connectToast('top', response.data.message)
                    this.resetForm()
                }
                else {
                    this.presentToast('top', 'Oups !!')
                }
            })
        },
        resetForm() {
            this.form = {
                name: '',
                nom: '',
                prenom: '',
                email: '',
                type: 'employe',
                poste: '',
                telephone1: '',
                telephone2: '',
                adresse: '',
                date_naissance: '',
                description: '',
                photo: '',
                commission: ''
            }
        }
    }
})
</script>