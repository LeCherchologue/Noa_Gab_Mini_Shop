<template>
    <ActionTemplate>
        <template #page_title>
            <h6>NOUVEAU TICKET</h6>
        </template>
        <template #content>
            <ion-progress-bar v-if="resIsLoading == true" type="indeterminate"></ion-progress-bar>
            <form v-else @submit.prevent="createLine()">
                <div class="form-group">
                    <label for="sujet">Sujet</label>
                    <input type="text" class="form-control" id="sujet" v-model="form.sujet" required>
                    <small>Pourquoi voulez-vous ouvrir une conversation avec ce service?</small>
                </div>

                <div class="form-group">
                    <label for="service_id">Service</label>
                    <select class="form-control" id="service_id" v-model="form.service_id" required>
                        <option v-for="service in services" :key="service.id" :value="service.id">
                            {{ service.libelle }}
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-block btn-primary" :disabled="isLoading">
                    <i class="fa-solid fa-save"></i> Creer
                    <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status"
                        aria-hidden="true"></span>
                </button>
            </form>
        </template>
    </ActionTemplate>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';

export default defineComponent({
    data() {
        return {
            isLoading: false,
            resIsLoading: true,
            form: {
                sujet: '',
                service_id: null,
                userId: this.$store.getters.user.id,
                user_name: this.$store.getters.user.name
            },
            services: [],
            baseUrl: this.$store.state.api_yams_livraisons
        };
    },
    mounted() {
        this.getServices()
    },
    methods: {
        async presentToast(position: 'top' | 'middle' | 'bottom', msg, duration, color) {
            const toast = await toastController.create({
                message: msg,
                duration: duration,
                position: position,
                color: color
            });

            await toast.present();
        },
        getServices() {
            this.resIsLoading = true
            this.axios.get(this.baseUrl + '/api/services').then((response) => {
                this.services = response.data
                this.resIsLoading = false
            }).catch(() => {
                this.resIsLoading = false
            })
        },
        createLine() {
            this.isLoading = true
            this.axios.post(this.baseUrl + '/api/tickets', this.form).then(response => {
                this.isLoading = false
                if (response.data.success === true) {
                    this.resetForm()
                    this.presentToast('top', response.data.message, 3000, 'success')
                    this.$router.push({ name: 'chat.index' })
                    window.location.replace('/chat')
                }
                else {
                    this.presentToast('top', response.data.errors[0], 5000, 'danger')
                }
            }).catch(() => {
                this.isLoading = false
                this.presentToast('top', 'Erreur de connexion', 5000, 'danger')
            })
        },
        resetForm() {
            this.form = {
                sujet: '',
                service_id: null,
                userId: this.$store.getters.user.id,
                user_name: this.$store.getters.user.name
            }
        }
    }
});
</script>