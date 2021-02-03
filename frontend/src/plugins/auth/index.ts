/* eslint-disable */
import Vue from 'vue'
import { App, provide, inject } from 'vue'
import AppComponent from './App.vue'
// import store from 'vuex'
import { Router } from 'vue-router'
import Base from '@/plugins/auth/base'
import authModule from '@/plugins/auth/store'
import { AuthState, HeaderDataState, AuthOption } from '@/types'

export default {
  install(app: App<typeof AppComponent>, options: AuthOption) {
    const namespace = 'auth'
    options.store.registerModule(namespace, authModule)
    const base = new Base(options.router, options.store)

    app.config.globalProperties.$authApp = base
    app.provide('authApp', base)

    options.router.beforeEach((to, from, next) => {
      if (to.matched.some(record => record.meta.requiresAuth)) {

        const checkAuthenticated = async () => await base.constructAction()
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

