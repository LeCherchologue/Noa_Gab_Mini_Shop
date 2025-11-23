<template>
        <ion-tabs>
        <ion-router-outlet></ion-router-outlet>
        <ion-tab-bar slot="bottom">
            <ion-tab-button tab="accueil" href="/accueil">
                <i class="fa-solid fa-house"></i>
                <ion-label>Accueil</ion-label>
            </ion-tab-button>

            <ion-tab-button tab="courses" href="/courses">
                <i class="fa-solid fa-folder"></i>
                <ion-label>Mes courses</ion-label>
            </ion-tab-button>

            <ion-tab-button tab="paiements" href="/paiements">
                <i class="fa-solid fa-folder-tree"></i>
                <ion-label>Paiements</ion-label>
            </ion-tab-button>
        </ion-tab-bar>
    </ion-tabs>
    
</template>