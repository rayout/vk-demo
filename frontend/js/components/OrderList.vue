<template>
    <div>
        <app-nav></app-nav>

        <order-list></order-list>
    </div>
</template>

<script>
    import AppNav from './AppNav';
    import OrderList from './OrderList';
    //import { isLoggedIn } from '../../utils/auth';
    export default {
        name: 'home',
        components: {

        },
        data() {
            return {
                orderList: '',
            };
        },
        methods: {
            isLoggedIn() {
                // return isLoggedIn();
            },
        }
    };
</script>