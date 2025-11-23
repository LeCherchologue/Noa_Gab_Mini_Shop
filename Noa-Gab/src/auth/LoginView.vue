<template>
  
  <div class="pt-5">
    <div class="col-md-4 mx-auto">
      <div class="">
        <div class="text-center mt-5">
          <img src="/src/assets/logo1.png" height="100" alt="Logo" loading="lazy" />
        </div>

        <div class="#card">
          <div class="#card-body py-4">
            <h2 class="text-center mb-4 text-primary">CONNEXION</h2>
            <form @submit.prevent="login()">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-user"></i>
                  </span>
                </div>
                <input placeholder="Email/Téléphone" type="text" class="form-control form-control-lg "
                  :class="{ 'is-invalid': status === false }" v-model="form.email" required autocomplete="email" >
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-lock"></i>
                  </span>
                </div>
                <input placeholder="Mot de passe" type="password" class="form-control form-control-lg"
                  :class="{ 'is-invalid': status === false }" v-model="form.password" required>
              </div>

              <div class=" mb-0 text-center">
                <button type="submit" class="btn btn-lg btn-block btn-primary" :disabled="isLoading">
                  <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status"
                    aria-hidden="true"></span>
                    Se connecter
                </button>

                <a href="/register" class="btn btn-link" >
                  Vous n'avez pas de compte ?
                </a>
              </div>
            </form>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</template>
  
<script>
import { toastController } from '@ionic/vue';

export default {
  components: [toastController],
  name: 'LoginView',
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
  mounted() {
    console.log(navigator.onLine)
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
    login() {
      this.isLoading = true
      this.axios.post('/api/login', this.form).then(response => {
        if (response.data.success === true) {
          const user = response.data.data
          this.axios.defaults.headers.common = {
            'Authorization': 'Bearer ' + user.token
          };

          this.$store.commit('setAuthenticated', user)
          this.$router.push({ name: 'accueil' })
          
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
        email: '',
        password: ''
      }
    },
    
  }
}
</script>

<style>
.login-box {
  min-width: 300px;
  max-width: 350px;
  margin: auto;
}

.mon-toast-personnalise {
  background-color: #4CAF50; /* Couleur de fond */
  color: #fff; /* Couleur du texte */
  /* Ajoutez d'autres styles personnalisés selon vos besoins */
}
</style>