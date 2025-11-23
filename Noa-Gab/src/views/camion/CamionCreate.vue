<template>
    <div class="ion-padding">
       
        <form v-if="step === 1" @submit.prevent="next()">
            <div class="form-group">
                <label>Image du camion</label>
                <input type="file" class="form-control" ref="photo" v-on:change="onFilePhoto()">
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label>Immatriculation</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" v-model="form.plaque" required>
                </div>
                <div class="form-group col-6">
                    <label>Modele</label><span class="text-danger">*</span>
                    <select class="form-control" v-model="form.modele_id">
                        <option v-for="modele in modeles" :value="modele.id" :key="modele.id">{{ modele.libelle }}</option>
                    </select>
                    <!-- <SearchDropdown v-model="form.modele_id" filter :options="modeles" optionLabel="libelle" optionValue="id" class="w-100" placeholder="Selectionner un modele" /> -->
                </div>
                <div class="form-group col-6">
                    <label>Charge (Tonnes)</label><span class="text-danger">*</span>
                    <select class="form-control" v-model="form.types_camion_id">
                        <option v-for="type in types_camions" :value="type.id" :key="type.id">{{ type.libelle }}</option>
                    </select>
                    <!-- <SearchDropdown v-model="form.types_camion_id" filter :options="types_camions" optionLabel="libelle" optionValue="id" class="w-100" placeholder="Selectionner un type" /> -->
                </div>
                <div class="form-group col-6">
                    <label>Carburant</label><span class="text-danger">*</span>
                    <select class="form-control" v-model="form.type_carburant" required>
                        <option>Essence</option>
                        <option>Gasoil</option>
                        <option>Diesel</option>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label>Kilometrage</label>
                    <input type="text" class="form-control" v-model="form.kilometrage">
                </div>
                <!-- <div class="form-group col-6">
                    <label>Proprietaire</label><span class="text-danger">*</span>
                    <select class="form-control" v-model="form.proprietaire_id">
                        <option v-for="proprietaire in proprietaires" :value="proprietaire.id" :key="proprietaire.id">{{ proprietaire.name }}</option>
                    </select>
                    
                </div> -->
            </div>

            <button type="submit" class="btn btn-primary mt-4">
                Suivant
            </button>
        </form>

        <form v-if="step === 2" @submit.prevent="saveCamion()">
            <div class="form-group">
                <label>Chauffeur principal</label>
                <select class="form-control" v-model="form.chauffeur_principal_id">
                    <option v-for="chauffeur in chauffeurs" :value="chauffeur.id" :key="chauffeur.id">{{ chauffeur.name }}</option>
                </select>
                <!-- <SearchDropdown v-model="form.chauffeur_principal_id" filter :options="chauffeurs" optionLabel="name" optionValue="id" class="w-100" placeholder="Selectionner un chauffeur" /> -->
            </div>
            <div class="form-group">
                <label>Chauffeur secondaire</label>
                <select class="form-control" v-model="form.chauffeur_secondaire_id">
                    <option v-for="chauffeur in chauffeurs" :value="chauffeur.id" :key="chauffeur.id">{{ chauffeur.name }}</option>
                </select>
                <!-- <SearchDropdown v-model="form.chauffeur_secondaire_id" filter :options="chauffeurs" optionLabel="name" optionValue="id" class="w-100" placeholder="Selectionner un second chauffeur" /> -->
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary" @click.prevent="prev()">
                    Precedent
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Enregistrer
                    <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </form>
        
    </div>
</template>

<script>
import $ from "jquery";
import { defineComponent, defineAsyncComponent } from 'vue';
import { toastController } from '@ionic/vue';

export default defineComponent({
    name: 'CreateCamion',
    components: {toastController},
    inject: ['dialogRef'],
    data() {
        return {
            isLoading: true,
            table: 'camions',
            step: 1,
            chauffeurs: [],
            proprietaires: [],
            modeles: [],
            types_camions: [],
            form: {
                plaque: '',
                modele_id: '',
                types_camion_id: '',
                type_carburant: '',
                kilometrage: '',
                proprietaire_id: this.$store.getters.user.id,
                chauffeur_principal_id: '',
                chauffeur_secondaire_id: '',
            }
        }
    },
    mounted() {
        this.getChauffeurs()
        this.getProprietaires()
        this.getModeles()
        this.getTypeCamion()
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
        onFilePhoto() {
            this.form.photo = this.$refs.photo.files[0];
        },
        getChauffeurs() {
            this.isLoading = true
            this.axios.get('/api/users?poste_user=Chauffeur').then((response) => {
                this.chauffeurs = response.data
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
        getProprietaires() {
            this.isLoading = true
            this.axios.get('/api/users?type_user=proprietaire').then((response) => {
                this.proprietaires = response.data
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
        getModeles() {
            this.isLoading = true
            this.axios.get('/api/modeles').then((response) => {
                this.modeles = response.data
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
        getTypeCamion() {
            this.isLoading = true
            this.axios.get('/api/types_camions').then((response) => {
                this.types_camions = response.data
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
        next() {
            this.step++
        },
        prev() {
            this.step--
        },
        saveCamion() {
            this.isLoading = true

            let modele = this.modeles.filter(item => item.id === this.form.modele_id)[0]
            let types_camion = this.types_camions.filter(item => item.id === this.form.types_camion_id)[0]
            let proprietaire = this.proprietaires.filter(item => item.id === this.form.proprietaire_id)[0]
            let chauffeur_principal = this.chauffeurs.filter(item => item.id === this.form.chauffeur_principal_id)[0]
            let chauffeur_secondaire = this.chauffeurs.filter(item => item.id === this.form.chauffeur_secondaire_id)[0]

            this.form.identite =  modele.libelle + ' '+ modele.marque.libelle + ', '+ types_camion.libelle
            this.form.proprietaire = proprietaire.name
            this.form.chauffeur_principal = chauffeur_principal.name
            this.form.chauffeur_secondaire = chauffeur_secondaire.name

            const config = {
                headers: { 'Content-Type': 'multipart/form-data' }
            }
            this.axios.post('/api/camions', this.form, config).then(response => {
                this.isLoading = false
                if(response.data.success === true){
                    this.resetForm()
                 
                    this.connectToast('top', response.data.message)
                  
                }
                else {
                    this.presentToast('top', 'Oups !!')
                }
            })
        },
        resetForm() {
            this.step = 1,
            this.form = {
                plaque: '',
                modele_id: '',
                types_camion_id: '',
                type_carburant: '',
                kilometrage: '',
                proprietaire_id: '',
                chauffeur_principal_id: '',
                chauffeur_secondaire_id: '',
            }
        },
      
    }
})
</script>
