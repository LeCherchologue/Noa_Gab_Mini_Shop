<template>
    <ion-page>
        <ion-header :translucent="true">
            <ion-toolbar>
                <div id="topbar">
                    <div class="d-flex justify-content-center">
                        <router-link to="/accueil">
                            <img src="/src/assets/yams.png" style="width: 70px; margin-left: 35px;">
                        </router-link>
                    </div>
                </div>
            </ion-toolbar>
        </ion-header>
        <ion-content :fullscreen="true">
            <div class="container text-center pt-3">
                <div v-show="step === 1">
                    <div class="responsive-div mx-auto pb-3">
                        <img class="responsive-image" src="/src/assets/visuel-12-07-2023.png" alt=""
                            style="width: 100%;">
                    </div>
                    <h1> Bienvenue sur <b>YAM'S Client:</b> </h1>
                    <p>

                        Grâce à notre application, vous pouvez désormais
                        gérer vos courses facilement et efficacement, directement depuis votre téléphone.
                    </p>
                </div>

                <div v-show="step === 2">
                    <div class="responsive-div mx-auto pb-3">
                        <img class="responsive-image" src="/src/assets/5.png" alt="">
                    </div>
                    <h1>Suivi en temps réel:</h1>
                    <p> En cas de retard ou de problème,
                        vous pouvez réagir rapidement et informer vos clients de manière proactive.</p>

                </div>

                <div v-show="step === 3">
                    <div class="responsive-div mx-auto pb-3">
                        <img class="responsive-image" src="/src/assets/3.png" alt="">
                    </div>
                    <h1>Historique des courses :</h1>
                    <p> Nous enregistrons toutes les courses pour vous permettre de conserver un historique détaillé,
                        utile pour l'analyse des performances, la facturation et les audits</p>
                </div>
                <div v-show="step === 4">
                    <div class="responsive-div mx-auto pb-3">
                        <img class="responsive-image" src="/src/assets/1.png" alt="">
                    </div>
                    <h1>Course à la demande:</h1>
                    <p> Vous pouvez planifier des courses quand vous le voulez,
                        en fonction de vos propres besoins spécifiques, depuis confort de votre canapé</p>
                </div>
            </div>
        </ion-content>
        <ion-footer>
            <ion-toolbar class="container">
                <button v-if="step === 1" type="button" class="btn btn-primary" @click="next()">
                    Suivant
                </button>
                <div v-if="step === 2" class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" @click="prev()">
                        Précédent
                    </button>
                    <button type="button" class="btn btn-primary" @click="next()">
                        Suivant
                    </button>
                </div>
                <div v-if="step === 3" class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" @click="prev()">
                        Précédent
                    </button>
                    <button type="button" class="btn btn-primary" @click="next()">
                        Suivant
                    </button>
                </div>
                <div v-if="step === 4" class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" @click="prev()">
                        Précédent
                    </button>
                    <button type="button" @click="configurationConnexion()" class="btn btn-primary">
                        Terminer
                    </button>
                </div>
            </ion-toolbar>
        </ion-footer>
    </ion-page>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({

    data() {
        return {
            isLoading: true,
            step: 1,
        }
    },
    methods: {
        next() {
            this.step++
        },
        prev() {
            this.step--
        },
        configurationConnexion() {
            this.$router.push({ name: 'login' })
            this.$store.commit('setHasSeenDidactitielAt', new Date())
        }
    }
})
</script>

<style scoped>
.responsive-div {
    width: 100vw;
    /* 100% de la largeur de l'écran */
    max-width: 500px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    /* S'assurer que l'image ne dépasse pas la div */
}

/* CSS pour l'image */
.responsive-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    /* Garde les proportions de l'image et remplit la div */
}
</style>