<template>
    <div id="topbar">
        <div class="d-flex justify-content-between m-2 align-items-center">
           
            <div>
                <router-link to="/">
                    <img src="/src/assets/yams transporteur.png" style="width: 70px; margin-left: 155px;">
                </router-link>
            </div>
        </div>
    </div>
    <ion-content>
        <div class="ion-padding mt-5">
            <form v-if="step === 1" @submit.prevent="next()">
                <div class="form-row">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Noms</label>
                            <input type="text"  class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label>Prenoms</label>
                            <input type="text"  class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Telephone</label>
                            <input type="text" class="form-control" >
                        </div>
                        <div class="form-group col-6">
                            <label>Email</label>
                            <input class="form-control" type="email" >
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <div class="form-group col-6">
                            <label>Boite Postale</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label>Adresse</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a type="submit" class="btn btn-secondary mt-4" href="/">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary mt-4">
                        Suivant
                    </button>
                </div>
            </form>
    
            <form v-else-if="step === 2" @submit.prevent="next()">
                <div class="form-row">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre de camions</label>
                            <input type="number"  class="form-control">
                        </div>
                      
                    </div>
                </div>
             
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-secondary mt-4" @click.prevent="prev()">
                        Précédent
                    </button>
                    <button type="submit" class="btn btn-primary mt-4">
                        Enregistré
                    </button>
                </div>
            </form>
        </div>
    </ion-content>
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
       
    }
})
</script>