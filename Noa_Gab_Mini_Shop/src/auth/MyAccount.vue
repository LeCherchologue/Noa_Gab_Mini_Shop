<template>
    <ActionTemplate>
        <template #page_title>
            <h6>MON COMPTE</h6>
        </template>
        <template #content>
            <div id="accordion">
                <!-- Accordion pour "Modifier mes informations" -->
                <div class="card mb-3">
                    <div class="card-header" id="headingOne">
                        <button class="btn " data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne">
                            Modifier mes informations
                        </button>
                    </div>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body p-1">
                            <div class="col-md-5 pb-3">
                                <img v-if="photoURL" :src="photoURL" id="photoPreview" class="img-thumbnail mx-auto"
                                    @click="triggerFileInput" alt="Photo sélectionnée">
                                <div v-else id="photoPlaceholder"
                                    class="d-flex justify-content-center align-items-center border border-secondary rounded"
                                    @click="triggerFileInput"
                                    style="width: 200px; height: 200px; cursor: pointer; max-width: 200px;">
                                    <i class="fas fa-upload fa-2x"></i>
                                    <span class="ml-2">Cliquez pour choisir une photo</span>
                                </div>
                            </div>
                            <form @submit.prevent="updateUser">
                                <input type="file" class="custom-file-input" id="photo" @change="handlePhotoUpload"
                                    style="display:none;">
                                <div class="form-group">
                                    <label>Nom d'utilisateur</label>
                                    <input type="text" class="form-control" :value="this.$store.state.user.name"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" :value="this.$store.state.user.email"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="phone1">Numéro de Téléphone 1</label>
                                    <input type="tel" class="form-control" id="phone1" v-model="form.telephone1">
                                </div>
                                <div class="form-group">
                                    <label for="phone2">Numéro de Téléphone 2</label>
                                    <input type="tel" class="form-control" id="phone2" v-model="form.telephone2">
                                </div>
                                <div class="form-group">
                                    <label for="birthdate">Date de Naissance</label>
                                    <input type="date" class="form-control" id="birthdate"
                                        v-model="form.date_naissance">
                                </div>
                                <div class="form-group">
                                    <label for="address">Adresse</label>
                                    <input type="text" class="form-control" id="address" v-model="form.adresse">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Sexe</label>
                                    <select class="form-control" id="gender" v-model="form.sexe">
                                        <option value="Masculin">Homme</option>
                                        <option value="Feminin">Femme</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-block btn-primary" :disabled="isLoading">
                                    <i class="fa-solid fa-save mr-2"></i> Mettre à jour
                                    <span v-if="isLoading == true" class="spinner-border spinner-border-sm"
                                        role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Accordion pour "Changer mon mot de passe" -->
                <div class="card mb-3">
                    <div class="card-header" id="headingTwo">
                        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo">
                            Changer mon mot de passe
                        </button>
                    </div>

                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body p-1">
                            <form @submit.prevent="updatePassword" class="py-3">
                                <div class="form-group">
                                    <label for="current_password">Ancien Mot de Passe</label>
                                    <input type="password" class="form-control" id="current_password"
                                        v-model="passwordForm.current_password">
                                </div>
                                <div class="form-group">
                                    <label for="new_password">Nouveau Mot de Passe</label>
                                    <input type="password" class="form-control" id="new_password"
                                        v-model="passwordForm.new_password">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmation du Nouveau Mot de Passe</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        v-model="passwordForm.password_confirmation">
                                </div>
                                <button type="submit" class="btn btn-block btn-primary" :disabled="isLoading">
                                    <i class="fa-solid fa-save mr-2"></i> Changer le Mot de Passe
                                    <span v-if="isLoading == true" class="spinner-border spinner-border-sm"
                                        role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bouton de déconnexion -->
            <ion-button expand="full" color="danger" @click="logout">Se déconnecter</ion-button>
        </template>
    </ActionTemplate>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
export default defineComponent({
    data() {
        return {
            isLoading: false,
            formData: {},
            passwordForm: {
                current_password: '',
                new_password: '',
                password_confirmation: ''
            },
            form: {
                telephone1: this.$store.state.user.telephone1,
                telephone2: this.$store.state.user.telephone2,
                adresse: this.$store.state.user.adresse,
                date_naissance: this.$store.state.user.date_naissance,
                sexe: this.$store.state.user.sexe,
            },
            photoURL: this.$store.state.user.photo
        }
    },
    methods: {
        handlePhotoUpload(event) {
            const file = event.target.files[0];
            this.form.photo = file;
            this.photoURL = URL.createObjectURL(file);
        },
        triggerFileInput() {
            document.getElementById('photo').click();
        },
        updateUser() {
            this.isLoading = true
            const config = {
                headers: { 'Content-Type': 'multipart/form-data' }
            }
            this.axios.post('/api/users/' + this.$store.state.user.id + '/update-profile', this.form, config).then(response => {
                if (response.data.success === true) {
                    this.$store.commit('setUserProfileDatas', response.data.data)
                    this.$toast.add({
                        severity: 'success',
                        detail: response.data.message,
                        life: 3000
                    });
                    this.key++
                }
                else {
                    this.$toast.add({
                        severity: 'error',
                        detail: response.data.errors[0],
                        life: 5000
                    });
                }
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
        updatePassword() {
            if (this.passwordForm.new_password !== this.passwordForm.password_confirmation) {
                alert('Les mots de passe ne correspondent pas.');
                return;
            }
            this.isLoading = true
            this.axios.post('/api/users/' + this.$store.state.user.id + '/update-password', this.passwordForm).then(response => {
                if (response.data.success === true) {
                    this.resetFormPassword()
                    this.$toast.add({
                        severity: 'success',
                        detail: response.data.message,
                        life: 3000
                    });
                    this.dialogRef.close()
                    this.$store.commit('clearUserData')
                    this.$router.push({ name: 'login' })
                }
                else {
                    this.$toast.add({
                        severity: 'warn',
                        detail: response.data.errors[0],
                        life: 15000
                    });
                }
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
        resetFormPassword() {
            this.formPassword = {
                current_password: '',
                new_password: '',
                password_confirmation: ''
            }
        },
        toggleAccordion(accordionNumber) {
            this.$set(this.accordionStatus, accordionNumber, !this.accordionStatus[accordionNumber]);
        },
        logout(): void {
            this.isLoading = true
            this.$store.commit('clearUserData')
            this.axios.post('/api/logout').then(response => {
                if (response.data.success === true) {
                    this.presentToast('top', response.data.message)
                }
                else {
                    this.$router.push({ name: 'login' })
                }
                this.isLoading = false

            }).catch(() => {
                this.isLoading = false
                this.presentToast('top', 'Une erreur s\'est produite lors de la connexion au serveur !')
            })
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