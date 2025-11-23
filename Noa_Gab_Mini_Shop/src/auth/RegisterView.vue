<template>
  <ion-page>
    <ion-content>
      <div class="col-md-4 mx-auto">
        <div class="text-center mb-3">
          <div class="text-center pt-3">
            <img src="/src/assets/logo1.png" height="100" alt="Logo" loading="lazy" />
          </div>
          <h2 class="text-center mb-1 text-primary pb-3">INSCRIPTION</h2>
        </div>
        <form @submit.prevent="register()">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-user"></i>
              </span>
            </div>
            <input placeholder="Nom" type="text" class="form-control form-control-lg " v-model="form.nom" required>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-user"></i>
              </span>
            </div>
            <input placeholder="Prénom" type="text" class="form-control form-control-lg " v-model="form.prenom"
              required>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-calendar"></i>
              </span>
            </div>
            <input placeholder="Date de naissance" type="date" class="form-control form-control-lg "
              v-model="form.date_naissance" required>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-phone"></i>
              </span>
            </div>
            <input placeholder="Téléphone" type="text" class="form-control form-control-lg " v-model="form.telephone1"
              required>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-envelope"></i>
              </span>
            </div>
            <input placeholder="Email" type="email" class="form-control form-control-lg" v-model="form.email" required>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-lock"></i>
              </span>
            </div>
            <input placeholder="Mot de passe" type="password" class="form-control form-control-lg"
              v-model="form.password" required>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-lock"></i>
              </span>
            </div>
            <input placeholder="Confirmer le mot de passe" type="password" class="form-control form-control-lg"
              v-model="form.password_confirmation" required>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-building"></i>
              </span>
            </div>
            <input placeholder="Nom de l'entreprise (optionelle)" type="text" class="form-control form-control-lg"
              v-model="form.raison_sociale">
          </div>

          <button type="submit" class="btn btn-primary btn-block mt-4 mb-3">
            S'enregistrer
            <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status"
              aria-hidden="true"></span>
          </button>
        </form>
        <div class="d-flex justify-content-center">
          <router-link :to="{ name: 'login' }" class="btn btn-link">
            Vous avez déjà un compte ? Se connecter
          </router-link>
         
        </div>
      </div>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';

export default defineComponent({
  components: [toastController],
  data() {
    return {
      isLoading: false,
      form: {
        nom: '',
        prenom: '',
        date_naissance: '',
        telephone1: '',
        email: '',
        password: '',
        password_confirmation: '',
        nom_entreprise: '',
        type: 'client',
        raison_sociale: '',
        statut: 'Nouvelle inscription'
      }
    }
  },

  methods: {
    register() {
      this.isLoading = true
      this.axios.post('/api/register', this.form).then((response) => {
        if (response.data.success == true) {
          this.resetForm()
          this.presentToast('top', response.data.message, 3000, 'success')
          this.$store.commit('setAuthenticated',response.data.data)
          this.$router.push({ name: 'verify.account' })
          
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
    async presentToast(position: 'top' | 'middle' | 'bottom', msg, duration, color) {
            const toast = await toastController.create({
                message: msg,
                duration: duration,
                position: position,
                color: color
            });

            await toast.present();
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
        raison_sociale: '',
      }
    }
  }
})
</script>
