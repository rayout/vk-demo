import Vue from 'vue';
import Router from 'vue-router';
import AppNav from './components/AppNav';

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'AppNav',
            component: AppNav,
        }
    ],
});