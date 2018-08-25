<template>
    <div>
        <app-nav></app-nav>

        <dashboard></dashboard>
    </div>
</template>

<script>
    import AppNav from './AppNav';
    import Dashboard from './Dashboard';
    import auth from '../services/auth';
    export default {
        name: 'home',
        components: {
            AppNav,
            Dashboard,
        },
        methods: {},
        mounted() {

        }
    };
</script>