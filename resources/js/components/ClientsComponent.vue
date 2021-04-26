<template>
    <div class="card" :class="{'col-md-6 col-sm-12':!openAddress, 'col-md-12 col-sm-12':openAddress}">
        <div class="card-header">Cliente: {{ client.name }}</div>

        <div class="card-body">
            <div v-if="!editClient">
                <p>E-mail: {{ client.email }}</p>
                <p>Dt. Nascimento: {{ format_date(client.birthday) }}</p>
            </div>
            <div v-else>
                <form id="clientFrm" v-on:submit.prevent>
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" name="name" id="nameEdit"
                            placeholder="Nome" v-model="client.name">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" name="email" id="emailEdit"
                            placeholder="E-mail" v-model="client.email">
                    </div>
                    <div class="form-group">
                        <label for="email">Dt. Nascimento</label>
                        <input type="date" class="form-control" name="birthday" id="birthdayEdit"
                            v-model="client.birthday">
                    </div>
                </form>
            </div>
        </div>
        <div class="card-footer">
            <button v-if="editClient" class="btn btn-primary" v-on:click="onClickUpdate">
                <i class="fa fa-check"></i>
                Salvar
            </button>

            <button v-else class="btn btn-primary" v-on:click="onClickEdit">
                <i class="fa fa-pencil"></i>
                Editar
            </button>

            <button class="btn btn-primary" v-on:click="onClickDelete">
                <i class="fa fa-user-times"></i>
                Excluir
            </button>

            <button v-if="!openAddress" class="btn btn-primary" v-on:click="onClickControlAddress"
                data-toggle="collapse" v-bind:data-target="'#addressColapse' + client.id"
                aria-expanded="false" v-bind:aria-controls="'addressColapse' + client.id"
            >
                <i class="fa fa-map-marker"></i>
                Gerenciar Endereço
            </button>
            <button v-else class="btn btn-primary" id="backBtn" v-on:click="openAddress = false">
                <i class="fa fa-undo"></i>
                Voltar
            </button>

            <address-component
                v-if="openAddress"
                :address="address"
                :client="client"
                :openAddress="openAddress"
            >
            </address-component>
        </div>
    </div>
</template>

<script>
import AddressComponent from './AddressComponent.vue';
import moment from 'moment';
    export default {
  components: { AddressComponent, moment },
        props: ['client'],

        data() {
            return {
                editClient: false,
                address: {
                    isDisabled: false,
                    hasAddress: false
                },
                openAddress: false,
            }
        },
        methods: {
            format_date(value){
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY')
                }
            },
            onClickDelete() {
                axios.delete(`/client/${this.client.id}`).then(() => {
                    this.$emit('delete');
                })
            },
            onClickEdit() {
                this.editClient = true;
                this.$emit('edit');
            },
            onClickUpdate() {
                $(".invalid-feedback").remove();
                $(".is-invalid").removeClass("is-invalid");

                let params = {
                    name: this.client.name,
                    email: this.client.email,
                    birthday: this.client.birthday
                };
                axios.put(`/client/${this.client.id}`, params)
                    .then((response) => {
                        this.editClient = false;
                        let client = response.data;
                        this.$emit('update', client);
                    })
                    .catch(error => {
                        console.log(error.response.data.errors);
                        $.each(error.response.data.errors, function (field, information) {
                            console.log(field, information);
                            $("#" + field + 'Edit').removeClass("is-valid");
                            $("#" + field + 'Edit').addClass("is-invalid");
                            $("#" + field + 'Edit').parent().append('<div class="invalid-feedback">' + information[0] + '</div>');
                        });
                    });
            },
            onClickControlAddress() {
                axios.get(`address/${this.client.id}`).then((response) => {
                    this.openAddress = true;

                    if(response.data){
                        if(!response.data.message){
                            this.address = response.data;
                            this.address.isDisabled = true;
                            this.address.hasAddress = true;
                        }
                    }
                })
            }
        }
    }
</script>
