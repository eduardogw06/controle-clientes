<template>
    <div class="collapse show" v-bind:id="'addressColapse' + client.id">
        <div class="card card-body">
            <form id="addressFrm" v-on:submit.prevent>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="zipcode">CEP</label>
                        <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="CEP"
                            v-model="address.zipcode" v-on:blur="validateZipcode()" maxlength="8">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="address">Endereço</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Endereço"
                            v-model="address.address" :disabled=address.isDisabled  maxlength="100">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="number">Nº</label>
                        <input type="text" class="form-control" name="number" placeholder="Nº"
                            v-model="address.number"  maxlength="10">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="nei">Bairro</label>
                        <input type="text" class="form-control" name="neighborhood" id="neighborhood" placeholder="Bairro"
                            v-model="address.neighborhood" :disabled=address.isDisabled  maxlength="50">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="city">Cidade</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="Cidade"
                            v-model="address.city" :disabled=address.isDisabled  maxlength="50">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="state">Estado</label>
                        <input type="text" class="form-control" name="state" id="state" placeholder="Estado"
                            v-model="address.state" :disabled=address.isDisabled  maxlength="2">
                    </div>
                </div>

                <button class="btn btn-success" v-on:click="onClickAddressUpdate">
                    <i class="fa fa-check"></i>
                    Salvar
                </button>
            </form>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['address', 'client', 'openAddress'],
        methods: {
            onClickAddressUpdate() {
                let params = {
                    zipcode: this.address.zipcode,
                    address: this.address.address,
                    number: this.address.number,
                    neighborhood: this.address.neighborhood,
                    city: this.address.city,
                    state: this.address.state,
                    client: this.client.id
                };

                if(!this.address.hasAddress) {
                    $(".invalid-feedback").remove();
                    $(".is-invalid").removeClass("is-invalid");

                    axios.post('/address', params)
                        .then((response) => {
                            let address = response.data;
                            $("#backBtn").click();
                        })
                        .catch(error => {
                            $.each(error.response.data.errors, function (field, information) {
                                $("#" + field).removeClass("is-valid");
                                $("#" + field).addClass("is-invalid");
                                $("#" + field).parent().append('<div class="invalid-feedback">' + information[0] + '</div>');
                            });
                        });

                } else {
                    axios.put(`/address/${this.address.id}`, params)
                        .then((response) => {
                            let address = response.data;
                            $("#backBtn").click();
                        })
                        .catch(error => {
                            $.each(error.response.data.errors, function (field, information) {
                                $("#" + field).removeClass("is-valid");
                                $("#" + field).addClass("is-invalid");
                                $("#" + field).parent().append('<div class="invalid-feedback">' + information[0] + '</div>');
                            });
                        });
                }

            },
            validateZipcode() {
                $(".invalid-feedback").remove();
                $(".is-invalid").removeClass("is-invalid");

                if(this.address.zipcode != ''){
                    axios.get(`address/validateZipcode/${this.address.zipcode}`)
                        .then((response) => {
                            if(response.data){
                                if(response.data.isValid){
                                    this.address.address = response.data.logradouro;
                                    this.address.city = response.data.localidade;
                                    this.address.state = response.data.uf;
                                    this.address.neighborhood = response.data.bairro;

                                    this.address.isDisabled = true;
                                }else {
                                    this.address.address = '';
                                    this.address.city = '';
                                    this.address.state = '';
                                    this.address.neighborhood = '';
                                    this.address.isDisabled = false;

                                    $("#zipcode").removeClass("is-valid");
                                    $("#zipcode").addClass("is-invalid");
                                    $("#zipcode").parent().append('<div class="invalid-feedback">CEP inválido</div>');
                                }

                            }
                        })
                        .catch(error => {
                            $("#zipcode").removeClass("is-valid");
                            $("#zipcode").addClass("is-invalid");
                            $("#zipcode").parent().append('<div class="invalid-feedback">' + error.response.data.message + '</div>');
                        });
                }
            }
        }
    }

</script>
