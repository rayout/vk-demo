<template>
    <div>
        <app-nav></app-nav>

        <dashboard></dashboard>
    </div>
</template>

<script>
    import AppNav from './AppNav';
    import Dashboard from './Dashboard';
    //import { isLoggedIn } from '../../utils/auth';
    export default {
        name: 'home',
        components: {
            AppNav,
            Dashboard,
        },
        data() {
        },
        methods: {}
    };
</script>