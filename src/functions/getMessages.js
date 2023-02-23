import axios from 'axios';

export default async function getMessages() {
    try {
        let res = await axios.get('http://localhost:3000/messages');
        return res.data;
    }
    catch (err) {
        return false
    }
}