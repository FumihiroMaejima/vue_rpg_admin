/* eslint-disable */
// import Vue from 'vue'
import { App } from 'vue'
import AppComponent from './App.vue'
// import { Router } from 'vue-router'
import AuthApp from '@/plugins/auth/authApp'
import authModule from '@/plugins/auth/store'
import { AuthOption } from '@/types'

export default {
  install(app: App<typeof AppComponent>, options: AuthOption) {
    const namespace = 'auth'
    options.store.registerModule(namespace, authModule)
    const authApp = new AuthApp(options.router, options.store)

    app.config.globalProperties.$authApp = authApp
    app.provide('authApp', authApp)

    options.router.beforeEach((to, from, next) => {
      if (to.matched.some(record => record.meta.requiresAuth)) {

        const checkAuthenticated = async () => await authApp.constructAction()
        checkAuthenticated().then((response: boolean) => {
          if (!response) {
            // ログイン画面へリダイレクト
            next({
              path: '/login'
            })
          } else {
            next()
          }
        })
      } else {
        next() // 認証情報が必要無い画面
      }
    })
  }
}

