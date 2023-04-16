import axios from 'axios';
import config from '../config';

export default async function getMessages(password) {
    try {
        console.log(password)
        let res = await axios.post(`${config.url}getMessages.php`, {
            password : password,
        });
        return res.data;
    }
    catch (err) {
        return false
    }
}