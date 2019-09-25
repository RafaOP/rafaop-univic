<template>
    <div>
        <div>
            <b-card-group deck>
                <DisciplinaComponent v-for="disciplina in disciplinas" :key="disciplina.id" :disciplina="disciplina"></DisciplinaComponent>
            </b-card-group>
        </div>
        <b-button class="mt-3" variant="success" to="/disciplinas/create">Cadastrar nova disciplina</b-button>
    </div>
</template>

<script>
    import DisciplinaComponent from "./Disciplina"
    export default {
        data() {
            return { disciplinas: [] }
        },
        methods: {
            read() {
                axios.get('/api/disciplinas').then(({data}) => {
                    data.forEach(disciplina => {
                        this.disciplinas.push(disciplina);
                    });
                });
            }
        },
        components: { DisciplinaComponent },
        created() {
            this.read();
        }
    }
</script>