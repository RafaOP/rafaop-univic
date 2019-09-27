<template>
    <b-card
        no-body
        style="max-width: 20rem;"
    >
        <template v-slot:header>
            <h4 class="mb-2">{{ disciplina.sigla }}</h4>
            <b-card-sub-title class="mb-2">{{ disciplina.nome }}</b-card-sub-title>
        </template>

        <b-card-body>
            <b-card-text>
                Carga horária de {{ disciplina.carga }}h
            </b-card-text>
        </b-card-body>

        <b-list-group flush>
                <b-list-group-item v-if="disciplina.professor_id">Essa disciplina é lecionada por {{ professor.nome }}</b-list-group-item>
                <b-list-group-item v-else>Esta disciplina <b>não tem</b> um professor.</b-list-group-item>
        </b-list-group>

        <b-card-body>
            <b-button @click="editDisciplina" variant="primary">Editar</b-button>
            <b-button id="show-btn" @click="$bvModal.show(modal_name)" variant="danger">Excluir</b-button>
        </b-card-body>

        <b-card-footer class="text-muted" style="font-size: 11px">Criada em {{ disciplina.created_at }}</b-card-footer>
        <b-card-footer class="text-muted" style="font-size: 11px">Alterada em {{ disciplina.updated_at }}</b-card-footer>

        <div>
            <b-modal :id="modal_name">
                <template v-slot:modal-title>
                    {{ disciplina.nome }}
                </template>
                <div class="d-block text-center">
                    <h3>Tem certeza que deseja excluir {{ disciplina.sigla }}?</h3>
                </div>
                <template v-slot:modal-footer>
                    <b-button class="mt-3" block @click="$bvModal.hide(modal_name)" variant="primary">Cancelar</b-button>
                    <b-button class="mt-3" block @click="deleteDisciplina" variant="danger">Excluir</b-button>
                </template v-slot:modal-footer>
            </b-modal>
        </div>
    </b-card>
</template>

<script>
    export default {
        data() {
            return {
                modal_name: 'modal-name',
                professor: null
            };
        },
        name: "Disciplina",
        props: { disciplina: Object },
        methods: {
            editDisciplina() {
                this.$router.push({ name: 'disciplinaedit', params: {disciplina: this.disciplina} });
            },
            deleteDisciplina() {
                this.$bvModal.hide(this.modal_name);
                axios.delete('/api/disciplinas', {data: {id: this.disciplina.id}}).then(({data}) => {
                    console.log(data);
                }).catch(function (error) {
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    };
                });

                this.$router.go();
            }
        },
        created() {
            this.modal_name = '_' + this.disciplina.id;
            if (this.disciplina.professor_id) {
                axios.post('/api/professor', {id: this.disciplina.professor_id}).then(({data}) => {
                    this.professor = data;
                }); 
            }
        }
    }
</script>