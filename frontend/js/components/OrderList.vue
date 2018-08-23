<template>
    <div class="container">
        <h3 class="text-center">Order list</h3>
        <hr/>
        <div class="card-columns">
            <div class="card" v-for="order in orderList">
                <div class="card-body">
                    <h5 class="card-title">{{ order.name }}</h5>
                    <p class="card-text">{{ order.descr }}</p>
                    <span class="d-block">User: {{ order.username }}</span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Price: {{ order.price }}</li>
                </ul>
                <div class="card-body text-right">
                    <a href="#" class="card-link">Выполнить</a>
                </div>
            </div>
        </div>
        <div class="d-block text-right mt-3">
            <button  class="btn btn-info log">Next 20</button>
        </div>
    </div>
</template>

<script>
    import AppNav from './AppNav';
    import OrderList from './OrderList';
    //import { isLoggedIn } from '../../utils/auth';
    export default {
        components: {
            AppNav,
            OrderList,
        },
        data() {
            return {
                orderList: [
                    {name: 'lol11', price: 30, username: 'ray'},
                    {name: 'lol2', price: 30, username: 'ray'},
                    {name: 'lol3', price: 30, username: 'ray'},
                    {name: 'lol4', price: 30, username: 'ray'},
                    {name: 'lol5', price: 30, username: 'ray'},
                    {name: 'lol6', price: 30, username: 'ray'},
                    {name: 'lol7', price: 30, username: 'ray'},
                    {name: 'lol8', price: 30, username: 'ray'},
                    {name: 'lol8', price: 30, username: 'ray'},
                ]
            };
        },
        methods: {
            isLoggedIn() {
                // return isLoggedIn();
            },
        }
    };
</script>
<style scoped>

.col {
    margin-bottom: 15px;
    border: 1px solid rgba(86,61,124,.2);
}
</style>