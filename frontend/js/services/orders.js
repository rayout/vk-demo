import axios from 'axios';

const URL = 'http://' + process.env.MIX_HOST +'/api/orders/list';

export default {

    list(offset_id) {
        offset_id = offset_id || 0;

        return axios.get(URL, {
            params: {
                offset_id: offset_id
            }
        })
    },

}