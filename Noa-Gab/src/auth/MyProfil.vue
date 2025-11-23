<template>
  <my-template>
      <template #content>
         
         <div class="container">
          <ProgressBar v-if="isLoading === true" mode="indeterminate" style="height: 6px"></ProgressBar>
         
          <Accordion class="pt-3">
            <AccordionTab header="Mon profil">
              <div >
                <div>
                  <div class="row">
                    <div class="col-4">
                      <img :src="this.$store.state.user.photo"  class="rounded-circle w-100">
                    </div>
                    <div class="col-8">
                      <form v-on:submit.prevent="updatePhoto()">
                        <div class="form-group">
                          <label style="font-size: 15px">Changer de photo </label>
                         
                           <FileUpload mode="basic" class="form-control" ref="file" :key="key" v-on:change="onFilePhoto()"/>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">
                          Mettre à jour la photo
                        </button>
                      </form>
                    </div>
                      </div>
                         
                      </div>
                    
              </div>
            </AccordionTab>
            <AccordionTab header="Mes informations">
              <div >
                <form  method="post" v-on:submit.prevent="updateProfile()">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nom d'utilisateur</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control"  v-model="formProfile.name" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                      <input type="email" :value="this.$store.state.user.email" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Telephone 1</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" v-model="formProfile.telephone1" placeholder="exp: +241 077207720" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Telephone 2</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" v-model="formProfile.telephone2" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Date de naissance</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" v-model="formProfile.date_naissance" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Adresse</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" v-model="formProfile.adresse" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Sexe</label>
                    <div class="col-sm-8">
                      <select class="form-control" v-model="formProfile.sexe" >
                        <option value="Masculin">Masculin</option>
                        <option value="Feminin">Feminin</option>
                      </select>
                    </div>
                  </div>
                  
                      <button type="submit" class="btn btn-success">
                        <span v-if="this.$store.state.isLoading === true" class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true"></span>
                        <i class="fa fa-save"></i> Mettre à jour
                      </button>
                   
                </form>
              </div>
            </AccordionTab>
            <AccordionTab header="Changer de mot de passe">
              <div >
                <button class="btn btn-sm btn-warning mr-2 mt-3" @click="updatePassord()" :disabled="isLoading">
                  <i class="fa-solid fa-key"></i> Rénitialiser le mot de passe
                  <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
              </div>
            </AccordionTab>
          </Accordion>
          <button type="submit" class="btn btn-block mt-4 btn-sm btn-danger" @click="logout()">
            Se déconnecter
          </button>
         
         </div>
      </template>
  </my-template>
</template>

<script>
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';
export default{
components: [toastController],
  data() {
      return {
          isLoading: false,
          formPhoto: {
              photo: this.$store.state.user.photo,
          },
          formProfile: {
              name: this.$store.getters.user.name,
              telephone1: this.$store.getters.user.telephone1,
              telephone2: this.$store.getters.user.telephone2,
              adresse: this.$store.getters.user.adresse,
              date_naissance: this.$store.getters.user.date_naissance,
              sexe: this.$store.getters.user.sexe,
              
          },
          key: 1,
      };
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
    onFilePhoto() {
      this.formPhoto.photo = this.$refs.file.files[0];
    },
    updatePhoto() {
      this.isLoading = true
      const config = {
        headers: { 'Content-Type': 'multipart/form-data' }
      }
      this.axios.post('/api/users/' + this.$store.state.user.id + '/update-photo', this.formPhoto, config).then(response => {
        if (response.data.success === true) {
          this.$store.commit('setUserPhoto', response.data.data)
          
          this.key++
        }
        else {
        }
        this.isLoading = false
      }).catch(() => {
        this.isLoading = false
      })
    },
    updateProfile() {
      this.isLoading = true
      this.$store.state.isLoading = true
      this.axios.post( '/api/users/'+this.$store.getters.user.id+'/update-profile', this.formProfile).then(response => {
        if(response.data.success === true){
          this.$store.commit('setUserProfile', response.data.data)
          this.$store.commit('setAuthenticated', this.$store.getters.user)
          this.connectToast('top', response.data.message)
          this.isLoading = false
          this.$store.state.isLoading = false
        }
        else {
          this.presentToast('top', response.data.errors[0])
          this.isLoading = false
          this.$store.state.isLoading = false
        }
      }).catch(() => {
        this.$store.state.isLoading = false
      })
    },
    updatePassord(){
      this.isLoading = true
      this.axios.post('/api/users/'+this.$store.getters.user.id+'/reset-password').then((response) => {
          this.isLoading = false
          if (response.data.success === true) {   
              this.connectToast('top', response.data.message)
          }
          else {
              this.presentToast('top',' Oups !!!')
          }
      }).catch(() => {
          this.isLoading = false
          
          this.presentToast('top','Une erreur s\'est produite lors de la connexion au serveur !')
      })
    },
    logout () {
          this.isLoading = true
          this.axios.post('/api/logout').then(response => {
              if(response.data.success === true){
                  this.$store.commit('clearUserData')
                  window.location.reload()
                  this.connectToast('top', response.data.message)
              }
              else {
                  this.$toast.add({
                      severity: 'error',
                      summary: 'Identifiants incorrect',
                      detail: response.data.errors[0],
                      life: 5000
                  });
                  this.presentToast('top', response.data.errors[0])
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
              this.presentToast('top', 'Une erreur s\'est produite lors de la connexion au serveur !')
          })
      },
  }
};
</script>