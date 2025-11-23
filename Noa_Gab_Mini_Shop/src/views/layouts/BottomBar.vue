<template>
    <ion-tab-bar slot="bottom">
        <ion-tab-button tab="accueil" href="/home">
            <i class="fa-solid fa-house icon-menu"></i>
            <ion-label>Accueil</ion-label>
        </ion-tab-button>
        <ion-tab-button tab="courses" href="/courses">
            <i class="fa-solid fa-folder icon-menu"></i>
            <ion-label>Courses</ion-label>
        </ion-tab-button>
        <ion-tab-button tab="factures" href="/factures">
            <i class="fa-solid fa-archive icon-menu"></i>
            <ion-label>Factures</ion-label>
        </ion-tab-button>
        <ion-tab-button tab="chat" href="/chat">
            <i class="fas fa-comment-dots icon-menu"></i>
            <ion-label>Chat</ion-label>
        </ion-tab-button>
    </ion-tab-bar>
</template>



<style scoped>
.icon-menu {
    font-size: 1.4rem;
    margin-bottom: 5px;
}
</style>
