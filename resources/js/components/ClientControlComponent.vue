<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <register-component @new="addClient"></register-component>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-flex-start">
                <clients-component
                    v-for="(client, index) in clients"
                    :key="client.id"
                    :client="client"
                    @update="updateClient(index, ...arguments)"
                    @delete="deleteClient(index)">
                >
                </clients-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                clients: []
            }
        },

        mounted() {
            axios.get('/client').then((response) => {
                this.clients = response.data;
            });
        },
        methods: {
            addClient(client) {
                this.clients.push(client);
            },
            deleteClient(index) {
                this.clients.splice(index, 1);
            },
            updateClient(index, client) {
                this.clients[index] = client;
            }
        }
    }
</script>
