/* eslint-disable */
import { App } from 'vue'
import AppComponent from './App.vue'
import AuthApp from '@/plugins/auth/authApp'
import authModule from '@/plugins/auth/store'
import { AuthOptions, AuthAppUtils } from '@/types'
import { inversionFlag } from '@/util'

export default {
  install(app: App<typeof AppComponent>, options: AuthOptions) {
    const namespace = 'auth'
    options.store.registerModule(namespace, authModule)
    const authApp = new AuthApp(options.router, options.store)

    app.provide('authApp', authApp)

    const authAppUtils: AuthAppUtils = {
      getHeader: authApp.getHeader,
      login: authApp.login,
      logout: authApp.logout
    }

    app.provide('authAppUtils', authAppUtils)

    options.router.beforeEach(async (to, from, next) => {
      if (to.matched.some(record => record.meta.requiresAuth)) {

        inversionFlag(options.loading)
        const checkAuthenticated = await authApp.checkAuthenticated()
        inversionFlag(options.loading)
        if (!checkAuthenticated) {
          // ログイン画面へリダイレクト
          next({
            path: '/login'
          })
        } else {
          next()
        }
      } else {
        next() // 認証情報が必要無い画面
      }
    })
  }
}

