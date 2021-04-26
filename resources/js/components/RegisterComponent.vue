<template>
    <div class="card">
        <div class="card-body">
            <form action="" v-on:submit.prevent="newClient()">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Nome:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Nome" v-model="name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">E-mail:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" id="email"
                            placeholder="E-mail" v-model="email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Dt. Nascimento:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="birthday" id="birthday"
                            v-model="birthday">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-user-plus"></i>
                    Cadastrar Cliente
                </button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                email: '',
                birthday: ''
            }
        },
        methods: {
            newClient() {
                $(".invalid-feedback").remove();
                $(".is-invalid").removeClass("is-invalid");

                let params = {
                    name: this.name,
                    email: this.email,
                    birthday: this.birthday,
                };

                axios.post('/client', params)
                    .then((response) => {
                        this.name = '';
                        this.email = '';
                        this.birthday = '';

                        let client = response.data;
                        this.$emit('new', client);
                    })
                    .catch(error => {
                        $.each(error.response.data.errors, function (field, information) {
                            $("#" + field).removeClass("is-valid");
                            $("#" + field).addClass("is-invalid");
                            $("#" + field).parent().append('<div class="invalid-feedback">' + information[0] + '</div>');
                        });
                    });
            }
        }
    }
</script>
