import axios from 'axios';
import auth from '../services/auth'

const URL = 'http://' + process.env.MIX_HOST;

export default {

    list(offset_id) {
        offset_id = offset_id || 0;

        return axios.get(URL + '/api/orders/list', {
            params: {
                offset_id: offset_id
            }
        })
    },
    add(title, price) {
        return axios.post(URL + '/api/order/add', {
                title: title,
                price: price,
            },
            {
                headers: auth.getAuthHeader()
            }
        )
    }

}