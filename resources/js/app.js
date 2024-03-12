import './bootstrap';
import './plugins/axios';
import router from './router';
import { createApp } from 'vue';
import home from './layouts/home.vue';
import Vue3Toast from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import i18n  from './i18n';

const app = createApp({});

app.component('home-component',home);
app.use(router);
app.use(i18n);
app.use(Vue3Toast,{autoClose:3000});
app.mount('#app');