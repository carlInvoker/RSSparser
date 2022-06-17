require('./bootstrap');

window.Vue = require('vue').default;

import { createApp } from 'vue'
import { createWebHistory, createRouter } from "vue-router";
import VueAxios from 'vue-axios';
// import Vuex from 'vuex';
import axios from 'axios';

import App from './App.vue';
import router from './router/router.js'
import store from './store/store.js'

const app = createApp(App).use(router).use(store)
app.use(VueAxios, axios)
// app.use(Vuex)
app.mount('#app');
