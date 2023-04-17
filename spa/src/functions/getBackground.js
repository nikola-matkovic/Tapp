import axios from 'axios';
import config from '../config';

export default async function getBackground(user, password) {
    try {
        let data = new FormData();
        data.append("password", password);
        data.append("user", user)
        let res = await axios.post(`${config.url}getBackground.php`, data);
        return {
            url: config.url + "upload/" + res.data[0].background,
            opacity : res.data[0].background_opacity
        }
    }
    catch (err) {
        return false
    }
}