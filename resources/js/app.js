require('./bootstrap');
import Auth from './auth.js';

window.auth = new Auth();
import Vue from 'vue';
import Vuetify from 'vuetify';

import colors from 'vuetify/lib/util/colors';

import {tree} from 'vued3tree'
import { DraggableTree } from "vue-draggable-nested-tree";

import Routes from '@/js/routes/routes.js';
import App from '@/js/views/App';

import Toolbar from './components/Toolbar';
import Drawer from './components/Drawer';
import Treeview from './components/Treeview';
import Footer1 from './components/Footer1';
import Login from './components/Login';
import Chart from './components/Chart';



Vue.use(Vuetify);

const vuetifyOptions  = new Vuetify({

    theme: {
        themes: {
            light: {
                primary: colors.red.darken4,
                secondary: '#424242',
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107'
            },
            dark: {
                primary: colors.red.darken4,
                secondary: '#FF5252',
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107'
            },
        },
    },
});

Vue.component('tree', tree);
Vue.component('Toolbar', Toolbar);
Vue.component('Drawer', Drawer);
Vue.component('tree', tree);
Vue.component('Footer1', Footer1);
Vue.component('Login', Login);
Vue.component('Chart', Chart);





window.Event = new Vue;
const app = new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App),
    vuetify: new Vuetify(vuetifyOptions)
});

export default app;

