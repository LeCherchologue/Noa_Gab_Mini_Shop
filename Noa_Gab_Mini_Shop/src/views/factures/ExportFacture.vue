<template>
    <button class="btn btn-secondary btn-block mb-1" @click="download()">
        <i class="fas fa-download"></i> Télécharger le PDF
    </button>
    <div hidden>
        <div id="facture" class="container-fluid">
            <Entete />
            <h3 class="my-3">Facture </h3>
            <div class="row d-flex justify-content-between mb-4">
                <div class="col-6">
                    <strong> N°0{{ datas.id }}</strong><br />
                    <strong> Date: </strong>{{ formatDate(datas.date_dechargement) }} <br />
                    <br />
                </div>
                <div class="col-6">
                    <p>
                        <strong> Nom : </strong>{{ (datas.client_nom) }} <br />
                        <strong> Tel: </strong>{{ datas.client_telephones }} <br />
                        <strong> Email: </strong>{{ datas.client_email }} <br />
                        <strong> Adresse: </strong>{{ datas.client_adresse }} <br />
                        <strong> BP: </strong>{{ datas.client_bp }}<br />
                    </p>
                </div>
            </div>

            <table class="table mb-3">
                <thead class="thead-light">
                    <tr style="line-height: 1px;">
                        <th scope="col">Description</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">P.U.</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                           Location {{ datas.type_course }}, {{ datas.code }}, {{ datas.adresse_chargement }} ({{ formatDate(datas.date_chargement) }}) - {{ datas.adresse_dechargement }} ({{ formatDate(datas.date_dechargement) }})
                        </td>
                        <td>1</td>
                        <td>{{ formatPrice(datas.trajet.montant) }}</td>
                        <td>{{ formatPrice(datas.trajet.montant) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="ml-auto col-6">
                <table class="table mb-3" style="line-height: 1px;">
                    <tbody>
                        <tr>
                            <td colspan="2"></td>
                            <td>Sous Total</td>
                            <td>{{ formatPriceWithDevise(datas.trajet.montant) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>Total TTC</td>
                            <td> {{ formatPriceWithDevise(datas.trajet.montant) }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="ml-auto col-5">
                <h6>La direction</h6>
                <img src="@/assets/yams-cachet.png" class="my-5">
            </div>

        </div>
    </div>
</template>



<script lang="ts">
import moment from 'moment'
import html2pdf from "html2pdf.js";
import Entete from '@/views/layouts/ExportHead.vue';
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'ExportFacture.vue',
    components: {Entete},
    props: {
        course: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            datas: this.course
        };
    },
    methods: {
        formatDate(val) {
            if (val) return moment(String(val)).format('DD/MM/YYYY')
        },
        formatPriceWithDevise(val) {
            if (val) return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'XAF' }).format(val)
        },
        formatPrice(val) {
            if (val) return new Intl.NumberFormat('de-DE').format(val)
        },
        download() {
            this.isLoading = true
            html2pdf().set({
                pagebreak: { mode: 'avoid-all' },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' },
                margin: [0.5, 0.5],
                filename: "Facture-" + this.course.id + '-' + this.course.client_nom,
                html2canvas: { scale: 2 },
                image: { type: 'jpeg', quality: 0.98 },
            }).from(document.getElementById("facture"))
                .toPdf()
                .get('pdf')
                .then(function (pdf) {
                    var totalPages = pdf.internal.getNumberOfPages();
                    pdf.setFontSize(10);
                    pdf.setTextColor(150);
                    for (var i = 1; i <= totalPages; i++) {
                        pdf.setPage(i);
                        pdf.text(' S.A.R.L au capital de 1.000.000 F CFA | Oloumi - BP: 1073 Libreville | Tel: +241 (0) 1 74 78 91 - 062 13 71 78 ' + "\n" + 'RCCM: GA-LBV-01-2020-B13-00255 / NIF: 054889 C  |Email: infos@yamslogistics.com / Site web: yamslogistics.com', pdf.internal.pageSize.getWidth() - 0.50, pdf.internal.pageSize.getHeight() - 0.50, { align: 'right' });
                    }
                })
                .save();
            setTimeout(() => {
                this.isLoading = false
            }, 5000)
        },
    }
});
</script>