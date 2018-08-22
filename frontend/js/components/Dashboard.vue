<template>
    <div>

    </div>
</template>

<script>
    import AppNav from './AppNav';
    import OrderList from './OrderList';
    //import { isLoggedIn } from '../../utils/auth';
    export default {
        name: 'dashboard',
        components: {
            AppNav,
            OrderList,
        },
        data() {

        },
        methods: {
            isLoggedIn() {
                // return isLoggedIn();
            },
        }
    };
</script>