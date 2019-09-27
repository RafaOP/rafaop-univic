<template>
    <div class="row d-flex justify-content-center">
        <b-form class="w-25" method="POST" @submit="onSubmit" @reset="onReset" v-if="show" @keydown="fe_errors = []; be_errors = {}">
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
                <b-input-group v-for="index in ntel" :key="index" class="mb-2">
                    <b-input-group-prepend id="tooltip-target" is-text>
                        <b-form-radio v-model="selected" :value="index - 1" aria-label="Principal"></b-form-radio>
                    </b-input-group-prepend>
                    <b-form-input v-if="index == 1" aria-label="Etiqueta" placeholder="Etiqueta" v-model="etiquetas[index - 1]" required></b-form-input>
                    <b-form-input v-else aria-label="Etiqueta" placeholder="Etiqueta" v-model="etiquetas[index - 1]"></b-form-input>
                    <b-form-input v-if="index == 1" aria-label="Telefone" placeholder="Telefone" v-model="telefones[index - 1]" required></b-form-input>
                    <b-form-input v-else aria-label="Telefone" placeholder="Telefone" v-model="telefones[index - 1]"></b-form-input>
                    <b-input-group-append v-if="index == 1">
                        <b-button variant="success" @click="addTelefone">+</b-button>
                    </b-input-group-append>
                    <b-input-group-append v-else>
                        <b-button variant="danger" @click="delTelefone">-</b-button>
                    </b-input-group-append>
                </b-input-group>
            </b-form-group>

            <b-tooltip target="tooltip-target" variant="secondary" triggers="hover">
                Selecione para marcar este telefone como o principal
            </b-tooltip>

            <template v-if="fe_errors.length">
                <b-alert v-for="error in fe_errors" :key="error" variant="danger" show>{{ error }}</b-alert>
            </template>

            <template>
                <b-alert v-for="field in be_errors" :key="field[0]" variant="danger" show>Erro de servidor: {{ field[0] }}</b-alert>
            </template>

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
                    telefones: [],
                },
                selected: 0,
                etiquetas: [],
                telefones: [],
                ntel: 1,
                show: true,
                fe_errors: [],
                be_errors: {}
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
                    let tel = this.professor.telefones[i];
                    this.etiquetas.push(tel.etiqueta);
                    this.telefones.push(tel.numero);
                    if (tel.principal)
                        this.selected = i;
                }
            }
        },
        name: "ProfessorForm",
        methods: {
            checkForm() {
                this.fe_errors = [];

                if (!this.form.nome)
                    this.fe_errors.push('O campo nome não pode estar vazio!');
                if (!isNaN(this.form.nome))
                    this.fe_errors.push('O campo nome não deve conter um número!');
                if (!this.form.matricula)
                    this.fe_errors.push('O campo matrícula não pode estar vazio!');
                if (!this.form.email)
                    this.fe_errors.push('O campo email não pode estar vazio!');
                if (!this.form.data_nasc)
                    this.fe_errors.push('O campo data de nascimento não pode estar vazio!');
                else if (new Date(this.form.data_nasc) >= new Date())
                    this.fe_errors.push('O campo data de nascimento não pode conter uma data no futuro!');
                else {
                    let date = new Date();
                    date.setFullYear(date.getFullYear() - 18);
                    if (new Date(this.form.data_nasc) > date)
                        this.fe_errors.push('O professor deve ter, no mínimo, 18 anos de idade!');
                }
                if (!this.etiquetas[this.selected] || !this.telefones[this.selected]) {
                    this.fe_errors.push('O campo com o telefone principal não pode estar vazio!');
                }

                for (let i = 0; i < this.ntel; ++i) {
                    if ((this.etiquetas[i] && !this.telefones[i]) || (!this.etiquetas[i] && this.telefones[i])) {
                        this.fe_errors.push('Tanto o campo etiqueta quando o campo telefone devem estar preenchidos!');
                        break;
                    }
                    else if (this.telefones[i]) {
                        if (this.telefones[i].length < 8) {
                            this.fe_errors.push('Telefone muito pequeno!');
                            break;
                        }
                        else if (this.telefones[i].length > 25) {
                            this.fe_errors.push('Telefone muito grande!');
                            break;
                        }
                    }
                }

                return this.fe_errors.length == 0;
            },
            // Exclui os campos de telefone vazios antes de enviar para o servidor
            validatePhonesFields() {
                for (let i = 0; i < this.ntel; ++i) {
                    if (!this.etiquetas[i] && !this.telefones[i]) {
                        this.etiquetas.splice(i, 1);
                        this.telefones.splice(i, 1);
                        if (this.selected > i)
                            this.selected--;
                        i--;
                        this.ntel--;
                    }
                }
            },
            onSubmit(evt) {
                evt.preventDefault();
                if (!this.checkForm()) return;
                this.validatePhonesFields();

                for (let i = 0; i < this.telefones.length; ++i) {
                    this.form.telefones.push({
                        'principal': (this.selected == i ? true : false),
                        'etiqueta': this.etiquetas[i],
                        'numero': this.telefones[i]
                    });
                }

                if (!this.professor) {
                    axios.post('/api/professores', {
                        email: this.form.email,
                        nome: this.form.nome,
                        matricula: this.form.matricula,
                        data_nasc: this.form.data_nasc,
                        telefones: this.form.telefones
                    }).then(data => this.$router.push({path: '/professores'}))
                    .catch(error => this.be_errors = (
                        // A maneira correta de fazer esse tratamento seria criando uma Exception
                        // com as mensagens desejadas
                        error.response.data.errors ? error.response.data.errors : {msg: ["Já existe outro professor com esta matricula"]}
                    ));
                }
                else {
                    axios.patch('/api/professores', {
                        id: this.form.id,
                        email: this.form.email,
                        nome: this.form.nome,
                        matricula: this.form.matricula,
                        data_nasc: this.form.data_nasc,
                        telefones: this.form.telefones
                    }).then(data => this.$router.push({path: '/professores'}))
                    .catch(error => this.be_errors = (
                        // A maneira correta de fazer esse tratamento seria criando uma Exception
                        // com as mensagens desejadas
                        error.response.data.errors ? error.response.data.errors : {msg: ["Já existe outro professor com esta matricula"]}
                    ));
                }
            },
            onReset(evt) {
                evt.preventDefault();
                // Limpa os valores do form
                this.form.email = '';
                this.form.nome = '';
                this.form.matricula = '';
                this.form.data_nasc = '';
                this.selected = 0;
                this.etiquetas = [],
                this.telefones = [],
                this.errors = [];
                this.ntel = 1;

                // Reseta o estado de validação do browser
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            addTelefone: function() {
                this.ntel += 1;
                this.telefones.length = this.ntel;
                this.etiquetas.length = this.ntel;
            },
            delTelefone: function() {
                this.ntel -= 1;
                if (this.selected > this.ntel)
                    this.selected = 0;
                this.telefones.length = this.ntel;
                this.etiquetas.length = this.ntel;
            }
        }
    }
</script>