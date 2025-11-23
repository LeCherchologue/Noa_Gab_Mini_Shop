<template>
    <ActionTemplate>
        <template #page_title>
            <h6>TICKET #{{ this.id_ticket }}</h6>
        </template>
        <template #content>
            <ion-progress-bar v-if="resIsLoading == true" type="indeterminate"></ion-progress-bar>
            <div>

                <div v-if="ticket != null && resIsLoading == false" class="chat-container container">
                    <p class="font-weight-bold">{{ ticket.service.libelle }}</p>
                    <p class="#text-center  font-italic">
                        <small><b>Sujet: </b>{{ ticket.sujet }}</small>

                    </p>
                    <div class="chat-messages">
                        <div v-for="ticket_message in ticket_messages" :key="ticket_message.id" class="message"
                            :class="{ 'sent': ticket_message.userId == this.$store.state.user.id, 'received': ticket_message.userId != this.$store.state.user.id }">
                            <div class="content">{{ ticket_message.content }}</div>
                        </div>
                    </div>

                    <p v-if="ticket.statut == 'Fermé'" class="text-center my-1">Ce ticket est fermé, vous ne pouvez
                        plus envoyer de message dessus</p>
                    <div v-else>
                        <form @submit.prevent="createLine" class="form-inline mb-3">
                            <input id="message-input" type="text" v-model="form.content" class="form-control mr-2"
                                placeholder="Tapez votre message..." style="flex: 1;">
                            <button type="submit" class="btn btn-primary">
                                <span v-if="isLoading == true" class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                <i v-else class="fa-solid fa-paper-plane"></i>
                            </button>
                        </form>
                        <p class="text-danger text-center my-1 font-italic">
                            --<small>Vous devez fermer le ticket une fois votre preoccupation résolu</small>--
                        </p>
                        <button type="button" class="btn btn-sm btn-block btn-outline-dark" @click="closeTicket()">
                            <i class="fa-solid fa-close"></i> Fermer ce ticket
                        </button>
                    </div>

                </div>

                <ion-infinite-scroll threshold="100px" @ionInfinite="getTicketMessages">
                    <ion-infinite-scroll-content loadingSpinner="bubbles"
                        loadingText="Chargement des données..."></ion-infinite-scroll-content>
                </ion-infinite-scroll>
            </div>

        </template>
    </ActionTemplate>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { toastController, modalController } from '@ionic/vue';

export default defineComponent({
    props: ['id_ticket'],
    data() {
        return {
            resIsLoading: false,
            isLoading: false,
            table: 'tickets',
            ticket: null,
            ticket_messages: [],
            start: 0,
            limit: 3,
            form: {
                content: null,
                userId: this.$store.getters.user.id,
                user_name: this.$store.getters.user.name,
                ticket_id: this.id_ticket
            },
            baseUrl: this.$store.state.api_yams_livraisons,
        };
    },
    created() {
        this.getTicket()
        // this.scrollToEnd();
        this.getTicketMessages();
    },
    methods: {
        getTicket() {
            this.resIsLoading = true
            this.axios.get(this.baseUrl + '/api/tickets/' + this.id_ticket).then((response) => {
                this.ticket = response.data
                this.resIsLoading = false
            }).catch(() => {
                this.resIsLoading = false
            })
        },
        dismissModal() {
            modalController.dismiss();
        },
        scrollToEnd() {
            const container = this.$el.querySelector('.chat-messages');
            container.scrollTop = container.scrollHeight;
        },
        async presentToast(position: 'top' | 'middle' | 'bottom', msg, duration, color) {
            const toast = await toastController.create({
                message: msg,
                duration: duration,
                position: position,
                color: color
            });

            await toast.present();
        },
        async getTicketMessages(event) {
            try {
                const rangeEnd = this.start + this.limit - 1;
                const response = await this.axios.get(this.baseUrl + '/api/ticket_messages?ticket_id=' + this.id_ticket, {
                    headers: {
                        Range: `bytes=${this.start}-${rangeEnd}`
                    }
                });

                // Ajout des nouvelles données
                this.ticket_messages = [...this.ticket_messages, ...response.data];

                // Mise à jour de la plage de requête
                this.start += this.limit;

                // Si event est défini, cela signifie que c'est une requête provenant de l'infinite scroll
                if (event) {
                    event.target.complete();
                }
            } catch (error) {
                console.log(error)
                if (event) {
                    event.target.complete();
                }
            }
        },
        closeTicket() {
            this.resIsLoading = true
            this.axios.post(this.baseUrl + '/api/tickets/' + this.id_ticket + '/validate').then(response => {
                this.resIsLoading = false
                if (response.data.success === true) {
                    this.$router.push({ name: 'chat.index' })
                }
                else {
                    this.presentToast('top', response.data.errors[0], 5000, 'danger')
                }
            }).catch(() => {
                this.resIsLoading = false
                this.presentToast('top', 'Erreur de connexion', 5000, 'danger')
            })
        },
        createLine() {
            this.isLoading = true
            this.axios.post(this.baseUrl + '/api/ticket_messages', this.form).then(response => {
                this.isLoading = false
                if (response.data.success === true) {
                    this.resetForm()
                    this.getTicketMessages();
                    // this.$nextTick(() => {
                    //     this.scrollToEnd();
                    // });
                }
                else {
                    this.presentToast('top', response.data.errors[0], 5000, 'danger')
                }
            }).catch(() => {
                this.isLoading = false
                this.presentToast('top', 'Erreur de connexion', 5000, 'danger')
            })
        },
        resetForm() {
            this.form = {
                content: null,
                userId: this.$store.getters.user.id,
                user_name: this.$store.getters.user.name,
                ticket_id: this.id_ticket
            }
        }
    }
});
</script>

<style scoped>
.chat-container {
    max-width: 600px;
    margin: auto;
    height: 80vh;
    display: flex;
    flex-direction: column;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
}

.message {
    margin-bottom: 10px;
}

.message.sent {
    text-align: right;
}

.message.received {
    text-align: left;
}

.message .content {
    display: inline-block;
    padding: 10px;
    border-radius: 10px;
}

.message.sent .content {
    background-color: #007bff;
    color: white;
}

.message.received .content {
    background-color: #f1f1f1;
    color: black;
}
</style>