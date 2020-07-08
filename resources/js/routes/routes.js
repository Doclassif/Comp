import Vue from 'vue';
import VueRouter from 'vue-router';

import Treeview from '@/js/components/Treeview';
import Tableview from '@/js/components/Tableview';
import Login from '@/js/components/Login';
import Home from '@/js/components/Home';
import Chart from '@/js/components/Chart';

Vue.use(VueRouter);

const router = new VueRouter ({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/tree',
            name: 'Treeview',
            component: Treeview
        },
        {
            path: '/Chart',
            name: 'Chart',
            component: Chart
        },
        {
            path: '/table',
            name: 'Tableview',
            component: Tableview
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        }
    ]
});

export default router;
