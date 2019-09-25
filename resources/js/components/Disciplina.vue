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

        <!-- <b-list-group flush>
            <b-list-group-item v-for="tel in professor.telefones" :key="tel.id" :tel="tel">{{ tel.etiqueta }}: {{ tel.numero }}</b-list-group-item>
        </b-list-group> -->

        <b-card-body>
            <b-button href="create" variant="primary">Editar</b-button>
            <b-button href="#" variant="danger">Excluir</b-button>
        </b-card-body>

        <b-card-footer class="text-muted" style="font-size: 11px">Criado em {{ disciplina.created_at }}</b-card-footer>
        <b-card-footer class="text-muted" style="font-size: 11px">Alterado em {{ disciplina.updated_at }}</b-card-footer>
    </b-card>
</template>

<script>
    export default {
        data() { return {}; },
        name: "Disciplina",
        props: { disciplina: Object },
        methods: {}
    }
</script>