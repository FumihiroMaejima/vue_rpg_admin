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
    const store = options.store
    const router = options.router
    const namespace = 'auth'
    const base = new Base(router)
    store.registerModule(namespace, authModule)

    app.config.globalProperties.$authApp = base
    app.provide('authApp', base)

    // check cookie for token
    const authData = { id: store.getters['auth/id'], token: ''}
    // console.log('router: ' + JSON.stringify(router, null, 2))

    base.authInstance(authData.id, authData.token).then((response) => {
      // set AuthData
      // this.getAuthData(response)
      console.log('authInstance: ' + JSON.stringify(response, null, 2))
      // console.log('store.state: ' + JSON.stringify(store.state, null, 2))
      // console.log('store.getters: ' + JSON.stringify(store.getters, null, 2))
      // console.log('store.getters[\'auth / name\']: ' + JSON.stringify(store.getters['auth/name'], null, 2))
      // console.log('store.state.auth: ' + JSON.stringify(store.state.auth, null, 2))

      // console.log('router: ' + JSON.stringify(router.currentRoute.value.path, null, 2))

      // バックエンド連携時にコメントアウトの削除
      /* if (!response.id) {
        // 認証情報が無い場合
        resetAction(router, true)
      } else if (router.currentRoute.value.path === '/login') {
        // 認証情報がある、かつログイン画面にアクセスした時はホーム画面にアクセス
        router.push('/')
      } */



      // 取得した認証情報の設定
      const result = { id: response.id, name: response.name, authority: {} }
      //console.log('store.dispatch: ' + JSON.stringify(store.dispatch('auth/getAuthData', result), null, 2))
      // storeへ格納
      store.dispatch('auth/getAuthData', result)
      console.log('store.state.auth: ' + JSON.stringify(store.state.auth, null, 2))

      // this.openLoading = false
    })
  }
}

export function resetAction(router: Router, resetCookie = false) {
  if (resetCookie) {
    // this.$cookies.remove(cnf.tokenStoreName)
    // token remove function
  }

  // refreshAuthData()
  // this.refreshAuthData()
  if (router.currentRoute.value.path !== '/login') {
    router.push('/login')
  }
}

