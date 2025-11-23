<template>
  <ion-page>
    
          <ion-header :translucent="true">
              <ion-toolbar>
                  <div id="topbar">
                      <div class="d-flex justify-content-between m-2 align-items-center">
                          <div  @click="openModal()">                                 
                            
                              <img :src="formPhoto.photo" class="rounded-circle " style="width: 35px;">
                             
                          </div>
                          <div>
                              <router-link to="/accueil">
                                  <img src="/src/assets/yams.png" style="width: 70px; margin-left: 35px;">
                              </router-link>
                          </div>
                          <div>
                              <div @click="openNotifications()" class="btn btn-lg">
                                  <i class="fa-regular fa-bell"></i>
                                  <span class="badge badge-danger notif-badge" v-if="this.$store.state.notifications.filter(item => item.read_at == null).length > 0"> {{ this.$store.state.notifications.filter(item => item.read_at == null).length }} </span>
                              </div>
                            
                          </div>
                         
                      </div>
                  </div>

                  <ion-modal :is-open="open">
                      <ion-content>
                        <ion-toolbar color="primary">
                         
                          <ion-buttons slot="end">
                            <ion-button color="light" @click="closeModal()"><span class="badge badge-secondary mx-2">x</span>fermer</ion-button>
                          </ion-buttons>
                        </ion-toolbar>
                        <div class="ion-padding">
                          <section class="accordion ">
                            <div class="tab">
                                <input  class="cb" type="checkbox" name="accordion-1" id="cb1">
                                <label for="cb1" class="tab__label">Mon profil</label>
                                <div class="tab__content">
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
                                            </button><br>
                                          </form>
                                        </div>
                                      </div>
                                             
                                    </div>
                                        
                                  </div>
                                </div>
                            </div>
                        </section>
          
                        <section class="accordion">
                            <div class="tab">
                                <input class="cb" type="checkbox" name="accordion-3" id="cb3">
                                <label for="cb3" class="tab__label">Changer de mot de passe</label>
                                <div class="tab__content">
                                  <div>
                                    <form class="form-horizontal my-3"  v-on:submit.prevent="updatePassword()">
                                      <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Ancien mot de passe</label>
                                        <div class="col-sm-8">
                                          <input type="password" class="form-control" v-model="formPassword.current_password" required>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Nouveau mot de passe</label>
                                        <div class="col-sm-8">
                                          <input type="password" class="form-control" v-model="formPassword.new_password" required>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Confirmation </label>
                                        <div class="col-sm-8">
                                          <input type="password" class="form-control" v-model="formPassword.password_confirmation" required>
                                        </div>
                                      </div>
                                      <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-save"></i> Mettre à jour
                                      </button>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </section>
          
                        <section class="accordion">
                          <div class="tab">
                              <input class="cb" type="checkbox" name="accordion-4" id="cb4">
                              <label for="cb4" class="tab__label">Mes informations</label>
                              <div class="tab__content">
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
                              </div>
                          </div>
                      </section>
                        </div>
                        <button type="submit" class="btn btn-block-2 mt-4 btn-sm btn-danger mx-2" @click="logout()">
                          Se déconnecter
                        </button><br>
                        <!-- <button type="submit" class="btn btn-block-2 mt-4 btn-sm btn-primary mx-2" @click="openModalCommentaire()">
                          Laisser un commentaire
                        </button> -->

                        <!-- <form action="" class="ion-padding">
                          <div class="form-group ion-padding">
                              <p class="text-center font-weight-bold">Avez vous un commentaire sur l'application ?</p>
                              <p class="text-center">Aidez nous à améliorer l'application</p>
                          </div>
                         
                          <textarea class="form-control" rows="5" placeholder="votre avis ?"></textarea>
                          <button type="submit" class="btn btn-primary mt-4 float-right" >
                            <i class="fa-solid fa-send"></i>Envoyer
                          </button>
                      </form> -->
                      </ion-content>
                  </ion-modal>

                  <!-- modal commentaire -->
                  <ion-modal :is-open="isOpenCommentaire" style="margin-top: 50%">
                    <ion-content>
                        <ion-toolbar color="primary">
                            <ion-buttons slot="end">
                              <ion-button color="light" @click="closeModalCommentaire()">fermer</ion-button>
                            </ion-buttons>
                        </ion-toolbar>
                        <form action="" class="ion-padding">
                            <div class="form-group ion-padding">
                                <p class="text-center font-weight-bold">LAISSER UN COMMENTAIRE</p>
                            </div>
                            <p class="text-center">Aidez nous à évaluer nos transporteurs</p>
                            <div class="cardGrade" style="margin-left: 25%;">
                              <i v-for="(star, index) in stars" :key="index" @click="rate(index + 1)" :class="{'fas': star, 'far': !star, 'star-selected': star}" class="fa-star icon"></i>
                            </div>
                            <textarea class="form-control" rows="8" placeholder="Que pensez-vous du collaborateur ?"></textarea>
                            <button type="submit" class="btn btn-primary mt-4 float-right" >
                              <i class="fa-solid fa-send"></i>Envoyer
                            </button>
                        </form>
                    </ion-content>
                </ion-modal>


                <!-- espace notification -->
                <ion-modal :is-open="isOpenNotifications">
                  <ion-content>
                      <ion-toolbar color="primary">
                          <ion-buttons slot="end">
                            <ion-button color="light" @click="closeNotifications()"><span class="badge badge-secondary mx-2">x</span>fermer</ion-button>
                          </ion-buttons>
                      </ion-toolbar>
                     <Notifications></Notifications>
                  </ion-content>
              </ion-modal>
              </ion-toolbar>
          </ion-header>
         <ion-content>
          <slot name="content"></slot>
         </ion-content>
         <ion-tab-bar slot="bottom">
          <ion-tab-button tab="accueil" href="/accueil">
              <i class="fa-solid fa-house"></i>
              <ion-label>Accueil</ion-label>
          </ion-tab-button>
          
          <ion-tab-button tab="courses" href="/courses" v-if="this.$store.getters.user.type == 'proprietaire'">
            <i class="fa-solid fa-folder"></i>
            <ion-label>Courses</ion-label>
          </ion-tab-button>
          <ion-tab-button tab="courses" href="/courses" v-if="this.$store.getters.user.type == 'employe' && this.$store.getters.user.poste == 'Chauffeur'">
            <i class="fa-solid fa-folder"></i>
            <ion-label>Courses</ion-label>
          </ion-tab-button>
          <ion-tab-button tab="camions" href="/camions" v-if="this.$store.getters.user.type == 'proprietaire'">
              <i class="fa-solid fa-bus"></i>
              <ion-label>Camions</ion-label>
          </ion-tab-button>
          <!-- <ion-tab-button tab="chauffeurs" href="/ChauffeurIndex" v-if="this.$store.getters.user.type == 'proprietaire'">
            <i class="fa-solid fa-user-group"></i>
            <ion-label>Chauffeurs</ion-label>
          </ion-tab-button>
          <ion-tab-button tab="clients" href="/clients" v-if="this.$store.getters.user.type == 'proprietaire'">
            <i class="fa-solid fa-user"></i>
            <ion-label>Clients</ion-label>
          </ion-tab-button> -->
          
          <!-- course propriétaire -->
          <!-- <ion-tab-button tab="interventions" href="/interventions" v-if="this.$store.getters.user.type == 'proprietaire'">
              <i class="fa-solid fa-gear"></i>
              <ion-label>Maintenance</ion-label>
          </ion-tab-button> -->
          
          <!-- <ion-tab-button tab="affectations" href="/affectations" v-if="this.$store.getters.user.type == 'employe' && this.$store.getters.user.poste == 'Chauffeur'">
              <i class="fa-solid fa-inbox"></i>
              <ion-label>Affectations</ion-label>
          </ion-tab-button> -->
          <ion-tab-button tab="annonces" href="/annonces" v-if="this.$store.getters.user.type == 'employe' && this.$store.getters.user.poste == 'Chauffeur'">
            <i class="fa-solid fa-list"></i>
            <ion-label>Annonces</ion-label>
        </ion-tab-button>
        <ion-tab-button tab="chat" href="/chat" v-if="this.$store.getters.user.type == 'employe' && this.$store.getters.user.poste == 'Chauffeur'">
          <i class="fa-solid fa-envelope"></i>
          <ion-label>Chat</ion-label>
      </ion-tab-button>
      </ion-tab-bar>
  </ion-page>

</template>


<script lang="ts">
import Notifications from '@/components/Notifications.vue';
import { defineComponent } from 'vue';
import { IonBadge} from '@ionic/vue';
import store from '@/store';
export default defineComponent({
components: { IonBadge, Notifications },
data() {
  return {
      isLoading: true,
      formPhoto: {
          photo: store.state.user.photo,
      },
      formProfile: {
          name: this.$store.getters.user.name,
          telephone1: this.$store.getters.user.telephone1,
          telephone2: this.$store.getters.user.telephone2,
          adresse: this.$store.getters.user.adresse,
          date_naissance: this.$store.getters.user.date_naissance,
          sexe: this.$store.getters.user.sexe,
          
      },
      formPassword: {
        current_password: '',
        new_password: '',
        password_confirmation: ''
      },
      key: 1,
      isOpenCommentaire: false,
      isOpenNotifications: false,
      stars: [false, false, false, false, false],
      open: false,
  };
},

mounted(){
  this.getNotifications()
  
},
methods: {
  openNotifications(){
    this.isOpenNotifications = true
  },
  closeNotifications(){
    this.isOpenNotifications = false
  },
  openModal(){
    this.open = true
  },
  closeModal(){
    this.open = false
  },
rate(rating) {
  if (this.stars[rating - 1]) {
    this.stars = this.stars.map((star, index) => index < rating - 1 ? true : false);
  } else {
    this.stars = this.stars.map((star, index) => index < rating);
  }
},
openModalCommentaire(){
    this.isOpenCommentaire = true
  },
  closeModalCommentaire(){
    this.isOpenCommentaire = false
  },
  getNotifications() {
      this.axios.get('/api/notifications').then((response) => {
          this.isLoading = false
          this.$store.commit('setNotifications', response.data)
      }).catch(() => {
          this.isLoading = false
      })
  },
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

  updatePassword() {
  this.isLoadingPassword = true
  this.axios.post( '/api/users/'+this.$store.state.user.id+'/update-password', this.formPassword).then(response => {
    if(response.data.success === true){
      this.connectToast('top', response.data.message)
      this.resetFormPassword()
      this.$store.commit('clearUserData')
      window.location.reload()
    }
    else {
     
      this.presentToast('top', response.data.errors)
    }
    this.isLoadingPassword = false
  }).catch(() => {
    this.isLoading = false
  })
},
  logout () {
      this.isLoading = true
      this.axios.post('/api/logout').then(response => {
          if(response.data.success === true){
              this.$store.commit('clearUserData')
              // this.$router.replace({ path: '/login' })
              window.location.reload()
              this.connectToast('top', response.data.message)
          }
          else {
              this.presentToast('top',' Identifiants incorrect !!!')
          }
          this.isLoading = false
          // this.$store.state.connexion = 0
          location.replace('/login'); 
      }).catch(() => {
          this.isLoading = false
          
          this.presentToast('top', 'Une erreur s\'est produite lors de la connexion au serveur !')
      })
  },
  resetFormPassword(){
    this.formPassword = {
      current_password: '',
      new_password: '',
      password_confirmation: ''
    }
  }
}
});
</script>

<style>

.notif-badge{
margin-left: -5px;
}
.cardGrade {
margin: 0 0.75rem 0.25rem 0.75rem;
}

.icon {
color: #0065FC;
width: 15%;
}

.icon[data-active=false] {
color: #d9d9d9;
}
</style>