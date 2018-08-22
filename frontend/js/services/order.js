import router from '../router';
import axios from 'axios';

const URL = 'http://' + process.env.MIX_HOST +'/api/order';


export default {


    list() {
        axios.get(URL + '/list').then(response => response.data)
    },
}