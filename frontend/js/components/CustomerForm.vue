<template>
    <div>
    </div>
</template>

<script>
    import AppNav from './AppNav';
    import OrderList from './OrderList';
    //import { isLoggedIn } from '../../utils/auth';
    export default {
        name: 'customer-form',
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