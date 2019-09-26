<template>
    <div>
        <div>
            <b-card-group deck>
                <ProfessorComponent v-for="professor in professores" :key="professor.id" :professor="professor"></ProfessorComponent>
            </b-card-group>
        </div>
        <b-button class="mt-3" variant="success" to="/professores/create">Cadastrar novo professor</b-button>
    </div>
</template>

<script>
    import ProfessorComponent from "./Professor"
    export default {
        data() {
            return { professores: [] }
        },
        methods: {
            read() {
                axios.get('/api/professores').then(({data}) => {
                    data.forEach(professor => {
                        this.professores.push(professor);
                    });
                });
            }
        },
        components: { ProfessorComponent },
        created() {
            this.read();
        }
    }
</script>