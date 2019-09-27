import Vue from "vue";
import VueRouter from "vue-router";

import Professores from "./components/Professores";
import ProfessorForm from "./components/ProfessorForm";
import Disciplinas from "./components/Disciplinas";
import DisciplinaForm from "./components/DisciplinaForm";
import Intro from "./components/Intro";

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
            name: 'disciplinacreate',
            component: DisciplinaForm,
        },
        {
            path: '/disciplinas/edit',
            name: 'disciplinaedit',
            component: DisciplinaForm,
            props: true
        },
        {
            path: '/',
            name: 'home',
            component: Intro
        }
    ]
});

export default routes;