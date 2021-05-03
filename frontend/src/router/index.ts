import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Members from '../views/Members.vue'
import AuthUser from '../views/AuthUser.vue'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Test from '../views/Test.vue'
import Roles from '../views/Roles.vue'
import GameEnemies from '../views/GameEnemies.vue'

const routes: Array<RouteRecordRaw> = [
  {
    path: '/members',
    name: 'Members',
    component: Members,
    meta: {
      requiresAuth: true,
      permissions: ['master', 'administrator', 'develop']
    }
  },
  {
    path: '/authuser',
    name: 'AuthUser',
    component: AuthUser,
    meta: {
      requiresAuth: true,
      permissions: ['master', 'administrator']
    }
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
    path: '/roles',
    name: 'Roles',
    component: Roles,
    meta: {
      requiresAuth: true,
      permissions: ['master', 'administrator']
    }
  },
  {
    path: '/game/enemies',
    name: 'GameEnemies',
    component: GameEnemies,
    meta: {
      requiresAuth: true,
      permissions: ['master', 'administrator']
    }
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
