import router from '../router';
import axios from 'axios';

const LOGIN_URL = 'http://' + process.env.MIX_HOST +'/api/login';


export default {

    authenticated: false,
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
        this.authenticated = false;
        router.push('/');
    },

    user() {
        return JSON.parse(localStorage.getItem('user'));
    },

    checkAuth() {
        let jwt = localStorage.getItem('token')
        this.authenticated = !!jwt;
        return this.authenticated;
    },

    getAuthHeader() {
        return {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
    }
}