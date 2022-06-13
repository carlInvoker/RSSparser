import VueRouter from 'vue-router'

import HomeComponent from '../components/HomeComponent.vue';
import CreateComponent from '../components/CreateComponent.vue';
import LoginComponent from '../components/LoginComponent.vue';
import EditComponent from '../components/EditComponent.vue';
import AdminComponent from '../components/EditComponent.vue';

const routes = [
  {
      name: 'home',
      path: '/',
      component: HomeComponent
  },
  {
      name: 'create',
      path: '/create',
      component: CreateComponent
  },
  {
      name: 'admin',
      path: '/admin',
      component: AdminComponent
  },
  {
      name: 'login',
      path: '/login',
      component: LoginComponent
  },
  {
      name: 'edit',
      path: '/edit/:id',
      component: EditComponent
  }
];

const router = createRouter({ history: createWebHistory(), routes})

export default router
