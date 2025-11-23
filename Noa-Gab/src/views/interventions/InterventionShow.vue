<template>
    <div class="container">
        <h5 class="mb-3">{{ this.dialogRef.data.camion.plaque }}</h5>
        <small class="font-italic ">{{ debut }} au {{ fin }}</small>
        <h6>{{ this.dialogRef.data.intervention_piece[0].piece.nom }} /  {{ this.dialogRef.data.intervention_piece[0].piece.qte }} qte</h6>
        <span class="badge badge-danger">{{ new Intl.NumberFormat('de-DE').format(this.dialogRef.data.montant) }} fcfa</span>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  import moment from 'moment';

  export default defineComponent({
    inject: ['dialogRef'],
    data() {
      return {
        isLoading: true,
        debut: '',
        fin: ''
      };
    },
    mounted() {
        console.log('show inter = ', this.dialogRef.data)
        this.debut = moment(this.dialogRef.data.debut).format('DD-MM-YYYY')
        this.fin = moment(this.dialogRef.data.fin).format('DD-MM-YYYY')
    },
    methods: {
     
    }
  });
  </script>