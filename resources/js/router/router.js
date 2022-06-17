// import VueRouter from 'vue-router'
import { createWebHistory, createRouter } from "vue-router";

import HomeComponent from '../components/HomeComponent.vue';
import ArticleComponent from '../components/ArticleComponent.vue';
import LoginComponent from '../components/LoginComponent.vue';
// import EditComponent from '../components/EditComponent.vue';
import AdminComponent from '../components/AdminComponent.vue';

const routes = [
  {
      name: 'home',
      path: '/',
      component: HomeComponent
  },
  {
      name: 'article',
      path: '/article',
      component: ArticleComponent,
      meta: {
        requiresAuth: true,
      },
      props: route => ({ query: route.query.id })
  },
  {
      name: 'admin',
      path: '/admin',
      component: AdminComponent,
      meta: {
        requiresAuth: true,
      },
  },
  {
      name: 'login',
      path: '/login',
      component: LoginComponent,
      meta: {
        hideForAuth: true,
      }
  },
];

const router = createRouter({ history: createWebHistory(), routes})

router.beforeEach((to, from, next) => {
  const loggedIn = localStorage.getItem('user')

  // if not logged in - redirect to login page
  if (to.matched.some(record => record.meta.requiresAuth) && !loggedIn) {
    next({
      path: '/login',
      query: { redirect: to.fullPath }
    })
    return
  }
  else {
    next()
  }
})

export default router
