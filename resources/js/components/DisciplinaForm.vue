<template>
    <div class="row d-flex justify-content-center">
        <b-form class="w-25" method="POST" @submit="onSubmit" @reset="onReset" v-if="show">
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
                        {{ selected ? selected.nome : "Professor" }}
                    </template>
                    <b-dropdown-item v-for="professor in professores" :key="professor.id" @click="selectProfessor(professor)">{{ professor.nome }}</b-dropdown-item>
                </b-dropdown>
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
                    nome: '',
                    sigla: '',
                    carga: null,
                    professor_id: null
                },
                professores: [],
                selected: null,
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
            else {  // Necessário para evitar um TypeError: this.professor is undefined
                this.form.id = '';
                this.form.nome = '';
                this.form.sigla = '';
                this.form.carga = '';
            }

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
            onSubmit(evt) {
                evt.preventDefault();
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
