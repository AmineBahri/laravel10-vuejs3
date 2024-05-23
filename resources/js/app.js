import './bootstrap';
import './plugins/axios';
import './vuetify';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css'; // Ensure you are using css-loader
import 'material-design-icons-iconfont/dist/material-design-icons.css'; // Ensure your project is capable of handling css files
import 'vuetify/styles';
import router from './router';
import { createApp } from 'vue';
import home from './layouts/home.vue';
import Vue3Toast from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import i18n  from './i18n';
import vuetify from './vuetify';

const app = createApp({});

app.component('home-component',home);
app.use(router);
app.use(i18n);
app.use(vuetify);
app.use(Vue3Toast,{autoClose:3000});
app.mount('#app');
