<template>
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <router-link to="/" class="navbar-brand">VK demo</router-link>
        </div>
        <div class="nav navbar-nav navbar-text" v-if="isLoggedIn">
            <div class="row">
                <div class="col-md12">Username: {{user.email}}</div>
            </div>
            <div class="row">
                <div class="col-md-12">Balance: {{user.balance}}</div>
            </div>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li>
                <button v-if="isLoggedIn" class="btn btn-danger log" @click="handleLogout()">Log out </button>
                <button v-else class="btn btn-info log" @click="handleLogin()">Log In</button>
            </li>
        </ul>


    </nav>
</template>

<script>
    import auth from '../services/auth';
    import router from '../router'
    export default {
        name: 'app-nav',
        data() {
            return {
                isLoggedIn: auth.checkAuth(),
                user: auth.user()
            }
        },
        methods: {
            handleLogin() {
                router.push('/login');
            },
            handleLogout() {
                auth.logout();
                this.isLoggedIn = false;
            }
        },
        mounted() {

        }
    };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .navbar-right { margin-right: 0px !important}

    .log {
        margin: 5px 10px 0 0;
    }
</style>