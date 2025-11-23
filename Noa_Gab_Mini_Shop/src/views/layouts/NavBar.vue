<template>
    <ion-header :translucent="true">
        <ion-toolbar >
            <div class="container">
            <div class="d-flex align-items-center row">
                <div class="col-4 text-left">
                    <router-link :to="{name: 'account'}" class="rounded-circle bg-secondary">
                        <img :src="this.$store.state.user.photo" class="p-1" style="width: 35px;">
                    </router-link>
                </div>
                <div class="col-4 text-center">
                    <router-link :to="{name: 'home'}" >
                        <img src="/src/assets/yams.png" style="width: 70px;">
                    </router-link>
                </div>
                <div class="col-4 text-right">
                    <router-link :to="{name: 'notifications'}" class="btn">
                        <i class="fa-regular fa-bell" style="font-size: 1.5rem;"></i>
                        <span class="badge badge-danger notif-badge" v-if="this.$store.getters.notificationCount > 0">
                            {{ this.$store.getters.notificationCount }}
                        </span>
                    </router-link>
                </div>
            </div>
        </div>
        </ion-toolbar>
    </ion-header>
</template>

<style scoped>
.notif-badge {
  margin-left: -5px;
  position: absolute;
  font-size: 0.8rem;
}
</style>
























