import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Admins from '../views/Admins.vue'
import AuthUser from '../views/AuthUser.vue'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Test from '../views/Test.vue'
import Role from '../views/Role.vue'

const routes: Array<RouteRecordRaw> = [
  {
    path: '/admins',
    name: 'Admins',
    component: Admins,
    meta: { requiresAuth: true }
  },
  {
    path: '/authuser',
    name: 'AuthUser',
    component: AuthUser,
    meta: { requiresAuth: true }
  },
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: { requiresAuth: true }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/test',
    name: 'Test',
    component: Test,
    meta: { requiresAuth: true }
  },
  {
    path: '/role',
    name: 'Role',
    component: Role,
    meta: { requiresAuth: true }
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
