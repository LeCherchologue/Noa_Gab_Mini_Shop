<template>
  <my-template>
    <template v-slot:content>
      <div class="container">
        <h5 class="mb-3">Paiements</h5>

        <list-paginated url="/api/paiements">
          <template v-slot:list_content = paiements>
            <ul class="list-group list-group-flush">
              <li v-for="paiement in paiements.datas" :key="paiement.id" class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <small class="font-weight-bold mr-3">#ID{{ paiement.id }} {{ paiement.date_paiement }}</small>
                  <br>
                  <span> {{ paiement.libelle }} </span>
                </div>
                <div>
                  <span> {{ new Intl.NumberFormat('de-DE').format(paiement.montant) }} FCFA</span>
                </div>
              </li>
            </ul>
          </template>
        </list-paginated>

      </div>

    </template>
  </my-template>
</template>




























<!-- <template>
  <my-template>
    <template v-slot:content>
      <div class="container">
        <h5 class="mb-3">Paiements</h5>
        <ProgressBar v-if="isLoading === true" mode="indeterminate" style="height: 6px"></ProgressBar>
        <ul class="list-group text-dark">
          <Paginator v-model:first="first" :rows="8" :totalRecords="totalRecords" @page="getPaiements()"></Paginator>
          <div :key="key">
            <li v-for="paiement in paiements" :key="paiement.id"
              class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <small class="font-weight-bold mr-3">#ID{{ paiement.id }} {{ paiement.date_paiement }}</small>
                <br>
                <span> {{ paiement.libelle }} </span>
              </div>
              <div>
                <span> {{ new Intl.NumberFormat('de-DE').format(paiement.montant) }} FCFA</span>
              </div>
            </li>
          </div>
          
        </ul>
      </div>

    </template>
  </my-template>
</template>

<script lang="ts">
import { IonLabel, IonSegment, IonSegmentButton } from '@ionic/vue';
import { defineComponent } from 'vue';

export default defineComponent({
  components: { IonLabel, IonSegment, IonSegmentButton },
  data() {
    return {
      isLoading: true,
      paiements: [],
      first: 1,
      url: '',
      rows: 8,
      key :1,
      totalRecords: 8
    };
  },
  created() {
    this.getPaiements()
  },
  methods: {
    getPaiements() {
      this.isLoading = true
      let page = 1

      if (this.first <= 0) {
        page = 1
      }
      else{
        page = (this.first / this.rows) + 1
      }
      this.axios.get('/api/paiements?page=' + parseInt(page) +'&rows='+ this.rows).then((response) => {
        this.isLoading = false
        this.paiements = response.data.data
        this.totalRecords = response.data.meta.total
        this.key++
      }).catch(() => {
        this.isLoading = false
      })
    }
  }
});
</script> -->
