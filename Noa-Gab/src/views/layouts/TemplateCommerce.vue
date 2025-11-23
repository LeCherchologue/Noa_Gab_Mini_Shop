<template>
    <ion-menu content-id="main-content" ref="menuRef">
        <ion-header>
          <ion-toolbar>
            <router-link to="/profil">                                 
                <img :src="this.$store.getters.user.photo" class="rounded-circle " style="width: 35px;">
            </router-link>
          </ion-toolbar>
        </ion-header>
        <ion-content class="ion-padding">
            <ion-list>
                <ion-item>
                    <a @click="goHome()">
                        Acceuil
                    </a>
                </ion-item>
                <ion-item>
                    <router-link to="/courses">
                        Courses
                    </router-link>
                </ion-item>
                <ion-item>
                    <router-link to="/camions">
                        Camions
                    </router-link>
                </ion-item>
                <ion-item>
                    <router-link to="/annonces">
                        Annonces
                    </router-link>
                </ion-item>
                <ion-item>
                    <router-link to="/clients">
                        Clients
                    </router-link>
                </ion-item>
              
            </ion-list>
        </ion-content>
    </ion-menu>
    <ion-page id="main-content">     
            <ion-header :translucent="true">
                <ion-toolbar>
                    <div id="topbar">
                        <div class="d-flex justify-content-between m-2 align-items-center">
                            <div>                                 
                                <button slot="start" class="mt-2">
                                    <ion-menu-button></ion-menu-button>
                                </button>
                            </div>
                            <div>
                                <router-link to="/accueil">
                                    <img src="/src/assets/yams transporteur.png" style="width: 70px; margin-left: 35px;">
                                </router-link>
                            </div>
                            <div>
                                <router-link to="/notifications" class="btn btn-lg">
                                    <i class="fa-regular fa-bell"></i>
                                    <span class="badge badge-danger notif-badge" v-if="this.$store.state.notifications.filter(item => item.read_at == null).length > 0"> {{ this.$store.state.notifications.filter(item => item.read_at == null).length }} </span>
                                </router-link>
                              
                            </div>
                           
                        </div>
                    </div>
                </ion-toolbar>
            </ion-header>
           <ion-content>
            <slot name="content"></slot>
           </ion-content>

    </ion-page>

</template>


<script lang="ts">
import { defineComponent } from 'vue';
import { IonBadge} from '@ionic/vue';
export default defineComponent({
components: { IonBadge },
data() {
    return {
        isLoading: true,
    };
},

mounted(){
    this.getNotifications()
    const menuElement = this.$refs.menuRef;
    
},
methods: {
    
    goHome(){
        this.$router.replace({path: '/accueil'})
    },
    getNotifications() {
        this.axios.get('/api/notifications').then((response) => {
            this.isLoading = false
            this.$store.commit('setNotifications', response.data)
        }).catch(() => {
            this.isLoading = false
        })
    },
    logout () {
        this.isLoading = true
        this.axios.post('/api/logout').then(response => {
            if(response.data.success === true){
                this.$store.commit('clearUserData')
                window.location.reload()
                this.$toast.add({
                    severity: 'success',
                    detail: response.data.message,
                    life: 3000
                });
            }
            else {
                this.$toast.add({
                    severity: 'error',
                    summary: 'Identifiants incorrect',
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
}
});
</script>

<style>

.notif-badge{
margin-left: -5px;
}
</style>