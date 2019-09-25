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
                    type="carga"
                    required
                    placeholder="Carga horária da disciplina"
                ></b-form-input>
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
                    nome: '',
                    sigla: '',
                    carga: null,
                },
                show: true
            }
        },
        name: "DisciplinaForm",
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                axios.post('/api/disciplinas', {disciplina: this.form}).then(({data}) => {
                    console.log('DATA');
                    console.log(data);
                }).catch(function (error) {
                    if (error.response) {
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    };
                });
            },
            onReset(evt) {
                evt.preventDefault();
                // Reset our form values
                this.form.nome = '';
                this.form.sigla = '';
                this.form.carga = null;

                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                });
            }
        }
    }
</script>