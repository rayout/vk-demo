<template>

</template>

<script>
    //import { isLoggedIn, login, logout } from '../../utils/auth';
    export default {
        name: 'app-nav',
        data() {
            return {
                email: 'joe@example.com',
                pass: '',
                error: false
            }
        },
        methods: {
            handleLogin() {
              //  login();
            },
            handleLogout() {
              //  logout();
            },
            isLoggedIn() {
               // return isLoggedIn();
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    };
</script>