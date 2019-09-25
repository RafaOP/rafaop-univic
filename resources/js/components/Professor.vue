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
            <b-list-group-item v-for="tel in professor.telefones" :key="tel.id" :tel="tel">{{ tel.etiqueta }}: {{ tel.numero }}</b-list-group-item>
        </b-list-group>

        <b-card-body>
            <b-button @click="editProfessor" variant="primary">Editar</b-button>
            <b-button @click="deleteProfessor" variant="danger">Excluir</b-button>
        </b-card-body>

        <b-card-footer class="text-muted" style="font-size: 11px">Criado em {{ professor.created_at }}</b-card-footer>
        <b-card-footer class="text-muted" style="font-size: 11px">Alterado em {{ professor.updated_at }}</b-card-footer>
    </b-card>
</template>

<script>
    export default {
        data() { return {}; },
        name: "Professor",
        props: { professor: Object },
        methods: {
            editProfessor() {
                console.log('Passing ' + this.professor.id);
                console.log(this.professor);
                this.$router.push({ name: 'professoredit', params: {professor: this.professor} });
            },
            deleteProfessor() {
                console.log('DELETE');
            }
        }
    }
</script>