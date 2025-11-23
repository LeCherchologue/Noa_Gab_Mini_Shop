<template> 
  <my-template>
      <template v-slot:content>
        <div class="container">
          <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar>
          <div>
            <h5 class="mb-3">Chat</h5>
          </div>
              <ul  class="list-group list-group-flush" >
                <li v-for="chat in chats" :key="chat.id"  @click="chatShow(chat.id, chat.service)" class="list-group-item d-flex justify-content-between align-items-center">
                  <div class="btn">
                    <div class="d-flex align-items-center row">
                        <div class="col-3">
                            <img src="../../assets/logo1.png" class="w-100 rounded-circle">
                        </div>
                        <div class="col-8">
                            <span class="font-weight-bold ">Service: {{ chat.service }}</span><br>
                        </div>
                      </div>
                  </div>
                </li>
              </ul>
          <ion-content class="ion-padding">
           
            <ion-modal :is-open="SendChat" id="modal">
              <ion-content>
                <ion-toolbar color="primary" id="toolbar">
                  <ion-buttons slot="end">
                    <ion-button color="light" @click="closeModalChat()"><span class="badge badge-secondary mx-2">x</span>fermer</ion-button>
                  </ion-buttons>
                </ion-toolbar>
                <form @submit.prevent="sendService()" class="ion-padding">
                  <div class="form-group ">
                    <label>Sélectionnez le service<span class="text-danger">*</span></label>
                    <select name="type" class="form-control" v-model="form.service">
                      <option value="Commercial">Commercial</option>
                      <option value="Support technique">Support technique</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary float-right">
                    <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status"
                    aria-hidden="true"></span>Créer
                  </button>
                </form> 
              </ion-content>
            </ion-modal>
          </ion-content>          
        </div>
        <a class="float" @click="openModalChat()">
          <i class="fab fa-add my-float"></i>
          <ion-fab>
            <ion-fab-button style="margin-top: 800%;">
            </ion-fab-button>
          </ion-fab>
        </a>
      </template>
    </my-template>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { toastController } from '@ionic/vue';
export default defineComponent({
  components: { toastController },
  data() {
      return {
          isLoading: false,
          form: {
            user_id: this.$store.state.user.id,
            service: '',
          },
          SendChat: false,
          chats: []
      };
  },

  mounted(){
      this.chat()
  },
  methods: {
    chat(){
        this.axios.get('/api/chats').then(response => {
          console.log('chat = ', response.data)
          this.chats = response.data
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
      openModalChat(){
        this.SendChat = true
      },
      closeModalChat(){
        this.SendChat = false
      },
     
      sendService(){
        this.axios.post('/api/chats', this.form).then(response => {
          this.isLoading = true

          if (response.data.success === true ) {
            this.connectToast('top', response.data.message)
            this.SendChat = false
            setTimeout(() => {
              this.chat()
            }, 1000);
          }
          else{
            this.presentToast('top', response.data.errors[0])
          }
          this.isLoading = false

        }).catch(() => {
          this.isLoading = false
        })
      },
      chatShow(id, service){
        this.$router.push({ path: `/ChatShow/${id}/${service}` })
      }
}
    

});
</script>

<style>
#modal {
--height: 30%;
--border-radius: 16px;
--box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

#modal::part(backdrop) {
background: rgba(209, 213, 219);
opacity: 1;
}

#modal #toolbar {
--background: rgb(14 116 144);
--color: white;
}
</style>