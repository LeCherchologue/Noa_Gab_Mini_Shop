<template>
    <TemplateCommerce>
        <template v-slot:content>
          <ProgressBar v-if="isLoading === true" mode="indeterminate" style="height: 6px"></ProgressBar>
          <div class="container">
            <form @submit.prevent="createLine()" class="ion-padding">
                <div class="form-group ">
                    <label>Trajet<span class="text-danger">*</span></label>
                    <!-- <v-select :options="trajets" label="libelle" v-model="form.trajet_id" :reduce="trajets => trajets.id" @input="setTrajetDatas"/> -->
                    <select class="form-control" v-model="form.trajet_id" @change="setTrajetDatas(form.trajet_id)">
                        <option v-for="trajet in trajets" :value="trajet.id" :key="trajet.id">{{ trajet.libelle }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Type de marchandise</label>
                    <input type="text" v-model="form.type_marchandise" class="form-control">
                </div>
        
                <div class="form-group ">
                    <label>Depart<span class="text-danger">*</span></label>
                    <input type="date" v-model="form.date_chargement"  class="form-control" required>
                </div>
                <div class="form-group ">
                    <label>Arrivée</label>
                    <input type="date" v-model="form.date_dechargement" class="form-control">
                </div>
                <div class="form-group ">
                    <label>Adresse de chargement<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="form.adresse_chargement">
                </div>
                <div class="text-center">
                    <button v-if="form.adresse_chargement && form.adresse_dechargement" class="btn btn-outline-info rounded-pill" type="button" @click.prevent="echangerAdresses()" required>
                        <ion-icon :icon="swapVertical" class="setting"/>
                    </button>
                </div>
                <div class="form-group ">
                    <label>Adresse de déchargement<span class="text-danger">*</span></label>
                    <input type="text" v-model="form.adresse_dechargement" class="form-control" required>
                </div>

            <div class="form-group mb-3">
                <label> Note </label>
                <textarea v-model="form.description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fa-solid fa-save"></i> Enregistrer
                <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
        </form>
          </div>
    
        </template>
      </TemplateCommerce>
</template>


<script lang="ts">
import { swapVertical } from 'ionicons/icons';
import moment from 'moment'


export default {
    data() {
        return {
            swapVertical,
            isLoading: false,
            table: 'annonces',
            trajets: [],
            form: {
                type_marchandise: '',
                date_chargement: moment().format('YYYY-MM-DD'),
                date_dechargement: '',
                adresse_chargement: '',
                adresse_dechargement: '',
                description: '',
                trajet_id: ''
            },
        }
    },
    mounted() {
        this.getTrajets()
    },

    methods: {
        goAnnonce() {
            this.$router.replace({ path: '/annonces'})
        },
      setTrajetDatas() {
            let trajet = this.trajets.filter(item => item.id === this.form.trajet_id)
            if (trajet[0]) {
                this.form.type_camion = trajet[0].type_camion
                this.form.adresse_chargement = trajet[0].depart
                this.form.adresse_dechargement = trajet[0].arrivee
            }
        },
        createLine() {
            this.isLoading = true
            this.axios.post('/api/annonces', this.form).then(response => {
                this.isLoading = false
                if (response.data.success === true) {
                    $('#refresh' + this.table).click()
                    this.$toast.add({
                        severity: 'success',
                        detail: response.data.message,
                        life: 3000
                    });
                    this.dialogRef.close()
                }
                else {
                    response.data.errors.forEach(element => {
                        this.$toast.add({
                            severity: 'warn',
                            summary: 'Oups !',
                            detail: element,
                            life: 7000
                        });
                    });
                }
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
        echangerAdresses() {
            let varTemp = this.form.adresse_chargement
            this.form.adresse_chargement = this.form.adresse_dechargement
            this.form.adresse_dechargement = varTemp
        },
        getTrajets() {
            this.isLoading = true
            this.axios.get('/api/trajets').then((response) => {
                this.trajets = response.data
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
        resetForm() {
            this.form = {
                type_marchandise: '',
                date_chargement: '',
                date_dechargement: '',
                adresse_chargement: '',
                adresse_dechargement: '',
                fichier_audio: '',
                description: '',
                modele_id: '',
                trajet_id: '',
            }
        }
    }
};
</script>