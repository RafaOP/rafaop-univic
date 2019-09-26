<template>
    <div class="row d-flex justify-content-center">
        <b-form class="w-25" method="POST" @submit="onSubmit" @reset="onReset" v-if="show">
            <b-form-group id="input-group-1" label="Nome:" label-for="nome">
                <b-form-input
                    id="nome"
                    v-model="form.nome"
                    required
                    placeholder="Nome do professor"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" label="Matricula:" label-for="matricula">
                <b-form-input
                    id="matricula"
                    v-model="form.matricula"
                    required
                    placeholder="Matricula do professor"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-3"
                label="Email:"
                label-for="email"
            >
                <b-form-input
                    id="email"
                    v-model="form.email"
                    type="email"
                    required
                    placeholder="Email do professor"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-4"
                label="Data de nascimento:"
                label-for="data_nasc"
            >
                <b-form-input
                    id="data_nasc"
                    v-model="form.data_nasc"
                    type="date"
                    required
                    placeholder=""
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-5"
                label="Telefones:"
                label-for="telefones"
            >
                <b-input-group prepend="Etiqueta e telefone" class="mb-2">
                    <template v-if="ntel >= 1">
                        <b-form-input aria-label="Etiqueta" placeholder="Etiqueta" v-model="form.etiquetas[0]"></b-form-input>
                        <b-form-input aria-label="Telefone" placeholder="Telefone" v-model="form.telefones[0]"></b-form-input>
                    </template>
                    <template v-else>
                        <b-form-input aria-label="Etiqueta" placeholder="Etiqueta" v-model="form.etiquetas[0]"></b-form-input>
                        <b-form-input aria-label="Telefone" placeholder="Telefone" v-model="form.telefones[0]"></b-form-input>
                    </template>
                        <b-input-group-append>
                            <b-button variant="success" @click="addTelefone">+</b-button>
                        </b-input-group-append>
                </b-input-group>

                <b-input-group v-for="index in (ntel-1)" :key="index" prepend="Etiqueta e telefone" class="mb-2">
                    <b-form-input aria-label="Etiqueta" placeholder="Etiqueta" v-model="form.etiquetas[index]"></b-form-input>
                    <b-form-input aria-label="Telefone" placeholder="Telefone" v-model="form.telefones[index]"></b-form-input>
                    <b-input-group-append>
                        <b-button variant="danger" @click="delTelefone">-</b-button>
                    </b-input-group-append>
                </b-input-group>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
        </b-form>
        <!-- <b-card class="mt-3" header="Form Data Result">
            <pre class="m-0">{{ form }}</pre>
        </b-card> -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    id: 0,
                    email: '',
                    nome: '',
                    matricula: '',
                    data_nasc: '',
                    etiquetas: [],
                    telefones: []
                },
                ntel: 1,
                show: true
            }
        },
        props: {
            professor: Object
        },
        created() {
            if (this.professor) {
                this.form.id = this.professor.id;
                this.form.email = this.professor.email;
                this.form.nome = this.professor.nome;
                this.form.matricula = this.professor.matricula;
                this.form.data_nasc = this.professor.data_nasc;
                this.ntel = this.professor.telefones.length;
                for (let i = 0; i < this.ntel; ++i) {
                    this.form.etiquetas.push(this.professor.telefones[i].etiqueta);
                    this.form.telefones.push(this.professor.telefones[i].numero);
                }
            }
            else {  // Necessário para evitar um TypeError: this.professor is undefined
                this.form.id = '';
                this.form.email = '';
                this.form.nome = '';
                this.form.matricula = '';
                this.form.data_nasc = '';
                this.ntel = 1;
            }

            // Se o professor não tem nenhum telefone cadastrado
            if (this.ntel == 0) {
                this.ntel = 1;
                this.form.etiquetas.push('');
                this.form.telefones.push('');
            }
        },
        name: "ProfessorForm",
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                if (!this.professor) {
                    axios.post('/api/professores', {professor: this.form}).then(({data}) => {
                        console.log(data);
                    }).catch(function (error) {
                        if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        };
                    });
                }
                else {
                    axios.patch('/api/professores', {professor: this.form}).then(({data}) => {
                        console.log(data);
                    }).catch(function (error) {
                        if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        };
                    });
                }

                this.$router.push({path: '/professores'});
            },
            onReset(evt) {
                evt.preventDefault();
                // Limpa os valores do form
                this.form.email = '';
                this.form.nome = '';
                this.form.matricula = '';
                this.form.data_nasc = '';
                this.form.etiquetas = [],
                this.form.telefones = [],
                this.ntel = 1;

                // Reseta o estado de validação do browser
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            addTelefone: function(e) {
                e.preventDefault();
                this.ntel += 1;
                this.form.telefones.length = this.ntel;
                this.form.etiquetas.length = this.ntel;
            },
            delTelefone: function(e) {
                e.preventDefault();
                this.ntel -= 1;
                this.form.telefones.length = this.ntel;
                this.form.etiquetas.length = this.ntel;
            }
        }
    }
</script>