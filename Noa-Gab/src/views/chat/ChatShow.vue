<template> 
  <my-template>
    <template v-slot:content>
      <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar>
      <div class="container d-flex">
        <div class="mt-3" >
          <router-link to="/chat">
            <i class='fa fa-arrow-left mt-2'></i>
          </router-link>
        </div>
        <div class="mx-4">
          <h2 class="text-center font-weight-bold">{{ service }}</h2>
        </div>
       
      </div>
      <ion-content>
          <div class="main" >
              <div class="container ">
                <div class="chat-log">
                  <div v-for="message in messages" :key="message.id">
                    <div v-if="message.chat_auteur == message.user.id" class="chat-log__item chat-log__item--own">
                      <h3 class="chat-log__author"> <small>{{ message.created_at }}</small></h3>
                      <div class="chat-log__message">{{ message.content }}</div>
                    </div>

                    <div v-else class="chat-log__item " id="topOfPage">
                      <h3 class="chat-log__author"> <small>{{ message.created_at }}</small></h3>
                      <div class="chat-log__message" id="cuisine" >{{ message.content }}</div>
                  
                    </div>
                  </div>
                  
                </div>
                <a id="#"></a>
              </div>
              <div style="position: fixed; bottom: 60px; width: 100%">
                <form @submit.prevent="sendMessage()" class="form-row" >
                    <div class="col-10">
                        <textarea class="form-control mr-sm-2" rows="1" v-model="form.content" placeholder="Ecrivez votre message"></textarea>
                    </div>
                    <div class="col-2">
                      <button type="submit" class="btn btn-primary" >
                        
                        <i class="fa-solid fa-paper-plane"></i>
                      </button>
                    </div>
                    
                    
                </form>
            </div>
            </div>
      </ion-content>
    </template>
  </my-template>
</template>

<script lang="ts">
import { exit } from 'ionicons/icons';
import { defineComponent } from 'vue';
export default defineComponent({
  data() {
      return {
          isLoading: false,
          service: '',
          form: {
            content: '',
            user_id: this.$store.state.user.id,
            chat_id: this.$route.params.id
          },
          messages: [],
          syncInterval: null,
      };
  },

  mounted(){
      this.service = this.$route.params.service
      this.getMessage()
        // this.syncInterval = setInterval( () => {
        //     this.getMessage()
        // }, 5000);
      
      console.log(this.$route)
      this.scrollToElement()
  },
  // beforeRouteLeave(to, from, next){
  //   clearInterval(this.syncInterval);
  //   next
  // },
  methods: {
    
    scrollToElement(){
      const topOfPageElement = document.getElementById('topOfPage');
      if (topOfPageElement) {
        topOfPageElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    },
    sendMessage(){
      this.axios.post('/api/chat_messages', this.form).then(response => {
        console.log('message = ', response.data)
        if (response.data.success == true) {
          this.reset()
         
          const self = this
          setTimeout(() =>{
            self.getMessage()
          }, 1000);

        }
      })
    },
    getMessage(){
      this.axios.get('/api/chat_messages?chat_id=' + this.$route.params.id).then(response => {
        console.log('message all = ', response.data)
        this.messages = response.data
        
      })
    },
    reset(){
      this.form = {
        content: '',
        user_id: this.$store.state.user.id,
        chat_id: this.$route.params.id
      }
    }
  }
});
</script>



<style>
  body { 
background: #E5DDD5 url("https://www.toptal.com/designers/subtlepatterns/patterns/sports.png") fixed;
  }
  .page-header {
  background: #006A4E;
  margin: 0;
    padding: 20px 0 10px;
 color: #FFFFFF;
 position: fixed;
 width: 100%;
   z-index: 1
}
  

  .chat-log {
  padding: 40px 0 114px;
  height: auto;
  overflow: auto;
}
  .chat-log__item {
  background: #DCF8C6;
  padding: 10px;
  margin: 0 auto 20px;
  max-width: 80%;
 float: left;
 border-radius: 4px;
 box-shadow: 0 1px 2px rgba(0,0,0,.1);
 clear: both;
}

  .chat-log__item.chat-log__item--own {
  float: right;
  background: #fafafa;
  text-align: right;
}

  .chat-form {
background: #DDDDDD;
bottom: auto;
position: fixed;
width: 100%;
}

.chat-log__author {
margin: 0 auto .5em;
font-size: 14px;
font-weight: bold;
}





</style>