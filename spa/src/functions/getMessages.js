import axios from 'axios';
import config from '../config';

export default async function getMessages(password) {
    try {
        let data = new FormData();
        data.append("password", password);
        let res = await axios.get(`${config.url}`);
        
        return res.data;
    }
    catch (err) {
        return false
    }
}