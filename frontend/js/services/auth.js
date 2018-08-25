import router from '../router';
import axios from 'axios';
import Vue from 'vue';

const LOGIN_URL = 'http://' + process.env.MIX_HOST +'/api/login';

export default {

    authenticated: false,
    user: {},
    login(login, password, context, redirect) {
        axios.post(LOGIN_URL, {
            login: login,
            pass: password
        })
        .then((response) => {
            console.log(response);
            localStorage.setItem('token', response.data.jwt);
            localStorage.setItem('user', JSON.stringify(response.data.user));

            this.authenticated = true;

            if(redirect) {
                router.push(redirect);
            }
        }).catch((err) => {
             context.error = err.response.data
        })
    },

    logout() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        this.authenticated = false;
        this.user = false;
        router.push('/');
    },

    getUser() {
        this.user = Object.assign({}, this.user, JSON.parse(localStorage.getItem('user')));
       // console.log(this.user);
        return this.user;
    },

    setBalance(balance) {
        Vue.set(this.user, 'balance', balance);
        localStorage.setItem('user', JSON.stringify(this.user));
       // console.log(this.user);
    },

    checkAuth() {
        let jwt = localStorage.getItem('token');
        this.authenticated = !!jwt;
        return this.authenticated;
    },

    getAuthHeader() {
        return {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
    },
    getToken() {
            localStorage.getItem('token')
    }
}