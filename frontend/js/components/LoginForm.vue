<template>

    <div class="text-center form-center">
        <div class="form-signin">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input v-model="login" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input v-model="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
            <button @click="submit()" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <div class="alert alert-danger" v-if="error">
                <p>{{ error }}</p>
            </div>
        </div>
    </div>

</template>

<script>
    import auth from '../services/auth'
    export default {
        data() {
            return {
                login: 'user1@test.ru',
                password: '123',
                error: '',
            }
        },
        methods: {
            submit() {
                auth.login(this.login, this.password, this, '/')
            }
        }
    }
</script>

<style>
    html, body, #app, .form-center {
        height: 100%;
    }

    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-center {
        display: -ms-flexbox;
        display: -webkit-box;
        display: flex;
        -ms-flex-align: center;
        -ms-flex-pack: center;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .alert {
        margin-top: 20px;
    }
</style>