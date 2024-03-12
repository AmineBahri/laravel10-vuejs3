import axios from 'axios';

axios.default.baseUrl = '/api';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
