<template>
    <div>
        <div>
            <b-navbar toggleable="lg" type="dark" variant="dark">
                <b-navbar-brand href="/">Univiçosa</b-navbar-brand>

                <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

                <b-collapse id="nav-collapse" is-nav>
                    <b-navbar-nav>
                        <b-nav-item to="/professores">Professores</b-nav-item>
                        <b-nav-item to="/disciplinas">Disciplinas</b-nav-item>
                    </b-navbar-nav>
                </b-collapse>
            </b-navbar>
        </div>
        <div class="p-3"><router-view></router-view></div>
    </div>
</template>

<script>
    export default {
        props: {
            
        },

        data: () => ({

        }),
    }
</script>
