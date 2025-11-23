
<template>
    <ion-header :translucent="true">
        <ion-toolbar>
            <div id="topbar">
                <div class="d-flex justify-content-between m-2 align-items-center">
                    <div @click="Profil()">
                        <img src="/src/assets/yams-qrcode-links.png" class="rounded-circle " style="width: 40px;">
                    </div>
                    <div>
                        <router-link to="/accueil">
                            <img src="/src/assets/logo1.png" style="width: 40px;">
                        </router-link>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-secondary rounded-circle bg-light">
                            <i class="fa-regular fa-bell"></i>
                        </button>
                    </div>
                    
                </div>
            </div>
        </ion-toolbar>
    </ion-header>
</template>
