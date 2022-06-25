import { createWebHistory, createRouter } from "vue-router";
import Create from "../pages/Create.vue";
import List from "../pages/List.vue";


const routes = [
    {
        path: '/',
        component: List,
        name: 'list',
    },
    {
        path: '/create',
        component: Create,
        name: 'create',
    },
    {
        path: '/edit/:id',
        component: Create,
        name: 'edit',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
