require('./bootstrap');

window.Vue = require('vue').default;

import { createApp } from 'vue'
import { createWebHistory, createRouter } from "vue-router";
import VueAxios from 'vue-axios';
import axios from 'axios';

import App from './App.vue';
import router from './router/router.js'

const app = createApp(App).use(router)
app.use(VueAxios, axios)
app.mount('#app');
