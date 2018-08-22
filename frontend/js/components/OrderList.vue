<template>
    <div class="container">
        <h3 class="text-center">Order list</h3>
        <hr/>

        <div class="row">
            <div class="col col-md-12" v-for="order in orderList">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"> {{ order.name }} </h3>
                    </div>
                    <div class="panel-body row align-items-center">
                        <div class=" col-sm-10">
                            <p><span class="badge alert-info"> price: </span> {{ order.username }} </p>
                            <p><span class="badge alert-danger"> from: </span><strong> {{ order.price }} </strong></p>
                        </div>
                        <div class=" col-sm-2">
                            <button  class="btn btn-info log" @click="handleLogin()">Log In</button>
                        </div>
                    </div>
                </div>
            </div>
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
                    {name: 'lol', price: 30, username: 'ray'},
                    {name: 'lol2', price: 30, username: 'ray'},
                    {name: 'lol3', price: 30, username: 'ray'},
                    {name: 'lol4', price: 30, username: 'ray'},
                    {name: 'lol5', price: 30, username: 'ray'},
                    {name: 'lol6', price: 30, username: 'ray'},
                    {name: 'lol7', price: 30, username: 'ray'},
                    {name: 'lol8', price: 30, username: 'ray'},
                    {name: 'lol2', price: 30, username: 'ray'},
                    {name: 'lol2', price: 30, username: 'ray'},
                    {name: 'lol2', price: 30, username: 'ray'},
                    {name: 'lol2', price: 30, username: 'ray'},
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