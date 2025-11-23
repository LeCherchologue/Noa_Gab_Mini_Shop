<template>
    <ActionTemplate>
        <template #page_title>
            <h6>DEMANDES</h6>
        </template>
        <template #content>
            <ul class="list-group">
                <li class="list-group-item" v-for="reservation in reservations" :key="reservation.id">
                    <b>Course {{ reservation.type_course }}</b> : {{ reservation.adresse_chargement }} ({{ reservation.date_chargement }}) - {{ reservation.adresse_dechargement }} ({{ reservation.date_dechargement }}). 
                    <span class="badge rounded-pill p-1 mx-2" :class="{ 'badge-danger' : reservation.statut == 'En attente'}">{{ reservation.statut }}</span>
                </li>
            </ul>
        </template>
    </ActionTemplate>
</template>

<script>
export default {
    data() {
        return {
            reservations: [],
            baseUrl: this.$store.state.api_yams_livraisons
        }
    },
    mounted() {
        this.getDemandes()
    },
    methods: {
        getDemandes() {
            this.resIsLoading = true
            this.axios.get(this.baseUrl + '/api/demandes?statut=En attente').then((response) => {
                this.reservations = response.data
                this.resIsLoading = false
            }).catch(() => {
                this.resIsLoading = false
            })
        },
    },
}
</script>