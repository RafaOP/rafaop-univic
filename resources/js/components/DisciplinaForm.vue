<template>
    <div class="row d-flex justify-content-center">
        <b-form class="w-25" method="POST" @submit="onSubmit" @reset="onReset" v-if="show" @keydown="fe_errors = []; be_errors = {}">
            <b-form-group id="input-group-1" label="Nome:" label-for="nome">
                <b-form-input
                    id="nome"
                    v-model="form.nome"
                    required
                    placeholder="Nome da disciplina"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" label="Sigla:" label-for="sigla">
                <b-form-input
                    id="sigla"
                    v-model="form.sigla"
                    required
                    placeholder="Sigla da disciplina"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-3"
                label="Carga horária:"
                label-for="carga"
            >
                <b-form-input
                    id="carga"
                    v-model="form.carga"
                    type="number"
                    min="0"
                    required
                    placeholder="Carga horária da disciplina"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-4"
                label="Professor:"
                label-for="professor"
            >
                <b-dropdown id="professor">
                    <template v-slot:button-content>
                        {{ selected ? selected.nome : "Sem professor" }}
                    </template>
                    <b-dropdown-item v-for="professor in professores" :key="professor.id" @click="selectProfessor(professor)">{{ professor.nome }}</b-dropdown-item>
                </b-dropdown>
            </b-form-group>

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
                    nome: '',
                    sigla: '',
                    carga: null,
                    professor_id: null
                },
                professores: [],
                selected: null,
                fe_errors: [],
                be_errors: {},
                show: true
            }
        },
        props: {
            disciplina: Object
        },
        created() {
            if (this.disciplina) {
                this.form.id = this.disciplina.id;
                this.form.nome = this.disciplina.nome;
                this.form.sigla = this.disciplina.sigla;
                this.form.carga = this.disciplina.carga;
                this.form.professor_id = this.disciplina.professor_id;
            }

            this.professores.push({'professor_id': null, 'nome': 'Sem professor'});
            axios.get('/api/professores').then(({data}) => {
                data.forEach(professor => {
                    this.professores.push(professor);
                    if (this.disciplina) {
                        if (this.disciplina.professor_id) {
                            if (this.disciplina.professor_id == professor.id)
                                this.selected = professor;
                        }
                    }
                });
            });
        },
        name: "DisciplinaForm",
        methods: {
            checkForm() {
                if (!this.form.nome)
                    this.fe_errors.push('O campo nome não pode estar vazio!');
                if (!this.form.sigla)
                    this.fe_errors.push('O campo sigla não pode estar vazio!');
                if (!this.form.carga)
                    this.fe_errors.push('O campo carga horária não pode estar vazio!');
                else if (isNaN(this.form.carga))
                    this.fe_errors.push('O campo carga horária deve ser um valor inteiro maior que zero!');
                else if (this.form.carga < 0)
                    this.fe_errors.push('O campo carga horária deve ser um valor inteiro maior que zero!');

                return this.fe_errors.length == 0;
            },
            onSubmit(evt) {
                evt.preventDefault();
                if (!this.checkForm()) return;

                if (!this.disciplina) {
                    axios.post('/api/disciplinas', {
                        nome: this.form.nome,
                        sigla: this.form.sigla,
                        carga: this.form.carga,
                        professor_id: this.form.professor_id
                    }).then(data => this.$router.push({path: '/disciplinas'}))
                    .catch(error => this.be_errors = (
                        // A maneira correta de fazer esse tratamento seria criando uma Exception
                        // com as mensagens desejadas
                        error.response.data.errors ? error.response.data.errors : {msg: ["Já existe outra disciplina com esta sigla!"]}
                    ));
                }
                else {
                    axios.patch('/api/disciplinas', {
                        id: this.form.id,
                        nome: this.form.nome,
                        sigla: this.form.sigla,
                        carga: this.form.carga,
                        professor_id: this.form.professor_id
                    }).then(data => this.$router.push({path: '/disciplinas'}))
                    .catch(error => this.be_errors = (
                        // A maneira correta de fazer esse tratamento seria criando uma Exception
                        // com as mensagens desejadas
                        error.response.data.errors ? error.response.data.errors : {msg: ["Já existe outra disciplina com esta sigla!"]}
                    ));
                }
            },
            onReset(evt) {
                evt.preventDefault();
                // Limpa os valores do form
                this.form.nome = '';
                this.form.sigla = '';
                this.form.carga = null;
                this.form.professor_id = null;
                this.selected = null;

                // Reseta o estado de validação do browser
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            selectProfessor(professor) {
                this.selected = professor;
                this.form.professor_id = professor.id;
            }
        }
    }
</script>
