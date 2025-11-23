<template>
  <ion-progress-bar type="indeterminate" v-if="isLoading === true" style="height: 6px"></ion-progress-bar>
  <div class="container">
      <h5 class="mb-3">{{ user }} {{ libelle }}</h5>
    
      <p>{{ description }}</p>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  inject: ['dialogRef'],
  props: ['data'],
  data() {
    return {
      isLoading: false,
      detail: [],
      libelle: '',
      description: '',
      user: ''
    };
  },
  mounted() {
    this.getNotification()
    console.log('props data = ', this.data)
  },
  methods: {
    showLibelle(val) {
        let notification = JSON.parse('[' + val + ']')
        this.libelle = notification[0].libelle
    },
    showUser(val) {
        let notification = JSON.parse('[' + val + ']')
        this.user = notification[0].user_name
    },
    showDescription(val) {
        let notification = JSON.parse('[' + val + ']')
        this.description = notification[0].description
        console.log('descript',notification[0].description)
    },
    getNotification() {
      this.isLoading = true
      this.axios.get('/api/notifications/' +  this.data.id).then((response) => {
        this.isLoading = false
        this.detail = response.data
        console.log('detail = ', this.detail[0].data)
        this.showLibelle(this.detail[0].data)
        this.showDescription(this.detail[0].data)
        this.showUser(this.detail[0].data)
      }).catch(() => {
        this.isLoading = false
      })
    }
  }
});
</script>