<template>
    <div>
        <customer-form></customer-form>
        <order-list></order-list>
    </div>
</template>

<script>
    import AppNav from './AppNav';
    import OrderList from './OrderList';
    import CustomerForm from './CustomerForm';
    //import { isLoggedIn } from '../../utils/auth';
    export default {
        name: 'dashboard',
        components: {
            AppNav,
            OrderList,
            CustomerForm,
        },
        // data() {
        //
        // },
        methods: {
            isLoggedIn() {
                // return isLoggedIn();
            },
        }
    };
</script>