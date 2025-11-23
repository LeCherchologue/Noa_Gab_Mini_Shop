<template>
  <div v-if="this.isLoading === true">
    <div class="overlay">
        <div class="overlay__inner">
            <div class="overlay__content">
                <span class="spinner"></span>
            </div>
        </div>
    </div>
  </div>
  <div :key="key">
      <slot name="list_content" :datas="datas"></slot>
  </div>
  <ProgressBar v-if="isLoading === true" mode="indeterminate" style="height: 6px"></ProgressBar>
  <!-- <Paginator v-model:first="first" :rows="rows" :totalRecords="totalRecords" @page="getDatas()"></Paginator> -->
  <button v-if="datas.length >= 7" type="button" class="btn btn-sm btn-block border border-dark"  @click="addLine()">
    <i class="fa-solid fa-arrows-rotate "></i> Charger plus
  </button>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
props:['url'],
data() {
  return {
    isLoading: true,
    datas: [],
    first: 1,
    rows: 7,
    key :1,
    totalRecords: 10
  };
},
mounted() {
  this.getDatas()
},

methods: {
  addLine(){
    this.isLoading = true
    this.$store.state.isLoading === false
    this.rows += 5;
    this.getDatas()
  },
  getDatas() {
    this.isLoading = true
    this.$store.state.isLoading === true
    let page = 1;

    if (this.first <= 0) {
      page = 1
    }
    else{
      page = (this.first / this.rows) + 1
    }
    let link = this.url
    if (link == undefined) return this.datas = []
    else if(link.includes('?')) link = link+'&'
    else link = link+'?'

    this.axios.get(link+'page=' + parseInt(page) +'&rows='+ this.rows).then((response) => {
      this.isLoading = false
      this.$store.state.isLoading === false
      this.datas = response.data.data
      this.totalRecords = response.data.meta.total
      this.key++
    }).catch(() => {
      this.isLoading = false
    })
  }
}
});
</script>
