import axios from 'axios';
const axiosBaseurl = axios.create({
    baseURL:'http://localhost:3002/checklistv2/api/'
});

export default axiosBaseurl;