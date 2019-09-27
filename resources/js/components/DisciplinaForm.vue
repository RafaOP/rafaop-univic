<template>
    <div class="row d-flex justify-content-center">
        <b-form class="w-25" method="POST" @submit="onSubmit" @reset="onReset" v-if="show" @keydown="errors = []">
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

            <template v-if="errors.length">
                <b-alert v-for="error in errors" :key="error" variant="danger" show>{{ error }}</b-alert>
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
                errors: [],
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
                    this.errors.push('O campo nome não pode estar vazio!');
                if (!this.form.sigla)
                    this.errors.push('O campo sigla não pode estar vazio!');
                if (!this.form.carga)
                    this.errors.push('O campo carga horária não pode estar vazio!');
                else if (isNaN(this.form.carga))
                    this.errors.push('O campo carga horária deve ser um valor inteiro maior que zero!');
                else if (this.form.carga < 0)
                    this.errors.push('O campo carga horária deve ser um valor inteiro maior que zero!');

                return this.errors.length == 0;
            },
            onSubmit(evt) {
                evt.preventDefault();
                if (!this.checkForm()) return;

                if (!this.disciplina) {
                    console.log('CREATE');
                    axios.post('/api/disciplinas', {disciplina: this.form}).then(({data}) => {
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
                    console.log('UPDATE');
                    axios.patch('/api/disciplinas', {disciplina: this.form}).then(({data}) => {
                        console.log(data);
                    }).catch(function (error) {
                        if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        };
                    });
                }

                this.$router.push({path: '/disciplinas'});
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
