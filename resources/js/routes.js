import Vue from "vue";
import VueRouter from "vue-router";

import Professores from "./components/Professores";
import ProfessorForm from "./components/ProfessorForm";
import Disciplinas from "./components/Disciplinas";
import DisciplinaForm from "./components/DisciplinaForm";
import Example from "./components/Example";

Vue.use(VueRouter);

const routes = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/professores',
            name: 'professores',
            component: Professores,
        },
        {
            path: '/professores/create',
            name: 'professorcreate',
            component: ProfessorForm,
        },
        {
            path: '/professores/edit',
            name: 'professoredit',
            component: ProfessorForm,
            props: true
        },
        {
            path: '/disciplinas',
            name: 'disciplinas',
            component: Disciplinas,
        },
        {
            path: '/disciplinas/create',
            name: 'disciplinascreate',
            component: DisciplinaForm,
        },
        {
            path: '/',
            name: 'home',
            component: Example
        }
    ]
});

export default routes;