/* eslint-disable */
import Vue from 'vue'
// import store from 'vuex'
import { Router } from 'vue-router'
import { Store } from 'vuex'
import Authentication from '@/plugins/auth/authentication'
const config: IAppConfig = require('@/config/data')
import { AuthState, HeaderDataState, AuthEndpoint, IAppConfig, BaseAddHeaderResponse } from '@/types'
export default class Base {
  router: Router
  store: Store<AuthState>
  endpoint: AuthEndpoint
  authentication: Authentication

  constructor(router: Router, store: Store<AuthState>) {
    this.router = router
    this.store = store
    this.endpoint = config.authEndpoint
    this.authentication = new Authentication(this.endpoint)
  }

  /**
   * first action after constructor.
   * check authenticated data.
   * @return {void}
   */
  async constructAction() {
    // check cookie for token
    const authData = { id: this.store.getters['auth/id'], token: '' }

    await this.authInstance(authData.id, authData.token).then((response) => {
      console.log('base authInstance: ' + JSON.stringify(response, null, 2))

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
      // storeへ格納
      this.store.dispatch('auth/getAuthData', result)
      console.log('base store.state.auth: ' + JSON.stringify(this.store.state.auth, null, 2))

      // this.openLoading = false
    })
  }

  /**
   * return authenticated id
   * @return {number} id
   */
  getAuthId() {
    return this.store.getters['auth/id']
  }

  /**
   * return authenticated name
   * @return {string} name
   */
  getAuthName() {
    return this.store.getters['auth/name']
  }

  /**
   * return authenticated authority
   * @return {Object} authority
   */
  getAuthAuthority() {
    return this.store.getters['auth/authority']
  }

  /**
   * reset relation data.
   * @param {HeaderDataState} data
   * @return {BaseAddHeaderResponse}
   */
  addHeaders(data: HeaderDataState) {
    return {
      Authorization: `Bearer ${data.token ? data.token : ''}`,
      'X-Auth-ID': data.id ? data.id : ''
    }
  }

  /**
   * reset relation data.
   * @param {number | null} id
   * @param {string | null} token
   * @return {Object}
   */
  async authInstance(id: AuthState['id'], token: HeaderDataState['token']) {
    const response = await this.authentication.getUser(this.addHeaders({id: id, token: token}))
    if (response.status !== 200) {
      return {
        id: null,
        name: null
      }
    } else {
      return {
        id: response.data.id,
        name: response.data.name
      }
    }
  }

  /**
   * reset relation data.
   * @param {boolean} resetCookie (default: false)
   * @return {void}
   */
  resetAction(resetCookie = false) {
  if (resetCookie) {
    // this.$cookies.remove(cnf.tokenStoreName)
    // token remove function
  }

  // refreshAuthData()
  // this.refreshAuthData()
  if (this.router.currentRoute.value.path !== '/login') {
    this.router.push('/login')
  }
}
}
