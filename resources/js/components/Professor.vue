<template>
    <b-card
        no-body
        style="max-width: 20rem;"
    >
        <template v-slot:header>
            <h4 class="mb-2">{{ professor.nome }}</h4>
            <b-card-sub-title class="mb-2">{{ professor.email }}</b-card-sub-title>
        </template>

        <b-card-body>
            <b-card-text>
                Matrícula {{ professor.matricula }}
                <br>
                Nascido em {{ professor.data_nasc }}
            </b-card-text>
        </b-card-body>

        <b-list-group flush>
            <b-list-group-item v-for="tel in professor.telefones" :key="tel.id" :tel="tel">
                {{ tel.etiqueta }}: {{ tel.numero }}
                <b-badge v-if="tel.principal" variant="info">Principal</b-badge>
            </b-list-group-item>
        </b-list-group>

        <b-card-body>
            <b-button @click="editProfessor" variant="primary">Editar</b-button>
            <!-- <b-button @click="deleteProfessor" variant="danger">Excluir</b-button> -->
            <b-button id="show-btn" @click="$bvModal.show(modal_name)" variant="danger">Excluir</b-button>
        </b-card-body>

        <b-card-footer class="text-muted" style="font-size: 11px">Criado em {{ professor.created_at }}</b-card-footer>
        <b-card-footer class="text-muted" style="font-size: 11px">Alterado em {{ professor.updated_at }}</b-card-footer>

        <div>
            <b-modal :id="modal_name">
                <template v-slot:modal-title>
                    {{ professor.nome }}
                </template>
                <div class="d-block text-center">
                    <h3>Tem certeza que deseja excluir {{ professor.nome }}?</h3>
                </div>
                <template v-slot:modal-footer>
                    <b-button class="mt-3" block @click="$bvModal.hide(modal_name)" variant="primary">Cancelar</b-button>
                    <b-button class="mt-3" block @click="deleteProfessor" variant="danger">Excluir</b-button>
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
                disciplinas: []
            };
        },
        name: "Professor",
        props: { professor: Object },
        methods: {
            editProfessor() {
                this.$router.push({ name: 'professoredit', params: {professor: this.professor} });
            },
            deleteProfessor() {
                this.$bvModal.hide(this.modal_name);
                axios.delete('/api/professores', {data: {id: this.professor.id}}).then(({data}) => {
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
            this.modal_name = '_' + this.professor.matricula;
        }
    }
</script>