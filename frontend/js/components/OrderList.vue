<template>
    <div class="container">
        <div class="text-center form-center" v-if="isCustomer()">
            <div class="form-order">
                <h1 class="h3 mb-3 font-weight-normal">Добавить новый заказ</h1>
                <label for="inputTitle" class="sr-only">Описание</label>
                <input v-model="order.title" type="text" id="inputTitle" class="form-control" placeholder="Описание" required="" autofocus="">
                <label for="inputPrice" class="sr-only">Цена</label>
                <input v-model="order.price" type="text" id="inputPrice" class="form-control" placeholder="Цена" required="">
                <button @click="addOrder()" class="btn btn-lg btn-primary btn-block" type="submit">Добавить</button>
                <div class="alert alert-danger" v-if="error">
                    <p>{{ error }}</p>
                </div>
            </div>
        </div>

        <h3 class="text-center">Список заказов</h3>
        <hr/>
        <div class="card-columns">
            <div class="card" v-for="(order, key) in orderList">
                <div class="card-body">
                    <h5 class="card-title">{{ order.title }}</h5>
                    <p class="card-text">{{ order.descr }}</p>
                    <span class="d-block">User: {{ order.customer_email }}</span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Price: {{ order.price }}</li>
                </ul>
                <div class="card-body text-right" v-if="isExecutor()">
                    <a @click="execute(key)" href="#" class="card-link">Выполнить</a>
                </div>
            </div>
        </div>
        <div class="d-block text-right mt-3">
            <button @click="next()" class="btn btn-info log">Next 20</button>
        </div>
    </div>
</template>

<script>
    import AppNav from './AppNav';
    import OrderList from './OrderList';
    import auth from '../services/auth';
    import orderService from '../services/orders';
    export default {
        components: {
            AppNav,
            OrderList,
        },
        data() {
            return {
                order: {
                    title: '',
                    price: '',
                },
                last_id: 0,
                orderList: [
                ],
                isLoggedIn: auth.checkAuth(),
                user: auth.getUser(),
                error: ''
            };
        },
        methods: {
            addOrder() {
                this.error = '';

                if(this.order.price >>> 0 !== parseFloat(this.order.price)){
                    this.error = 'Цена может быть только числом';
                    return false;
                }

                if(this.order.title === '' || this.order.price === ''){
                    this.error = 'Все поля обязательны к заполнению';
                    return false;
                }

                if(this.order.price > auth.getUser().balance){
                    this.error = 'Не достаточно средств для размещения заказа';
                    return false;
                }
                orderService.add(this.order.title, this.order.price).then((res)=>{
                    this.orderList.unshift(Vue.util.extend({}, this.order));
                    auth.setBalance(parseFloat(res.data.balance)); //get from server actual balance
                    this.$root.$emit('user', auth.getUser()); // знаю что хрень =/
                    this.order.title = '';
                    this.order.price = '';
                }).catch((err)=>{
                    alert(err.response.data.error);
                });

            },
            isCustomer() {
                return auth.checkAuth() && auth.getUser().role === 'customer'
            },
            isExecutor() {
                return auth.checkAuth() && auth.getUser().role === 'executor'
            },
            execute(index) {
                console.log(this.orderList);
                let order_id = this.orderList[index].id;

                orderService.execute(order_id).then((res)=>{
                    auth.setBalance(parseFloat(res.data.balance)); //get from server actual balance
                    this.$root.$emit('user', auth.getUser()); // знаю что хрень =/
                    this.orderList.splice(index, 1)
                }).catch((err)=>{
                    alert(err.response.data.error);
                    this.orderList.splice(index, 1)
                });

            },
            next(last_id) {
                last_id = last_id || this.last_id;
                orderService.list(this.last_id).then((res)=>{
                    this.orderList = res.data.orders;
                    this.last_id = this.orderList.slice(-1)[0].id;
                })
            }
        },
        mounted() {
            if (auth.checkAuth()) {
                this.order.email = auth.getUser().email;
            }
            this.next();

        }
    };
</script>
<style scoped>

    .form-order {
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
    .form-order .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }

    .form-order input[type="text"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .form-order input[type="number"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .form-order .form-control:focus {
        z-index: 2;
    }
    .alert {
        margin-top: 15px;
    }
</style>