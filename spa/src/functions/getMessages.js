import axios from 'axios';
import config from '../config';

export default async function getMessages(password) {
    try {
        console.log(password)
        let data = new FormData();
        data.append("password", password);
        let res = await axios.post(`${config.url}getMessages.php`, data);
        console.log(res)
        return res.data;
    }
    catch (err) {
        return false
    }
}