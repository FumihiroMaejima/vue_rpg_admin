/* eslint-disable */
import { Router } from 'vue-router'
import { Store } from 'vuex'
import Authentication from '@/plugins/auth/authentication'
const config: IAppConfig = require('@/config/data')
import { AuthState, HeaderDataState, AuthEndpoint, IAppConfig, BaseAddHeaderResponse } from '@/types'
export default class Base {
  public router: Router
  private store: Store<AuthState>
  private endpoint: AuthEndpoint
  private authentication: Authentication
  private appKey: string

  constructor(router: Router, store: Store<AuthState>) {
    this.router = router
    this.store = store
    this.endpoint = config.authEndpoint
    this.authentication = new Authentication(this.endpoint)
    this.appKey = 'application_token'
  }

  /**
   * first action after constructor.
   * check authenticated data.
   * @return {void}
   */
  async constructAction() {
    const token: string = this.getCookie(this.appKey)
    // tokenが無い場合はデータを初期化する
    if (token === '') {
      this.resetAction()
      return
    }

    await this.authInstance(this.store.getters['auth/id'], token).then((response) => {
      console.log('base authInstance: ' + JSON.stringify(response, null, 2))

      // バックエンド連携時にコメントアウトの削除
      if (!response.id) {
        // 認証情報が無い場合
        this.resetAction(true)
      } else if (this.router.currentRoute.value.path === '/login') {
        // 認証情報がある状態でログイン画面にアクセスした場合はホーム画面にアクセス
        this.router.push('/')
      }

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
  protected addHeaders(data: HeaderDataState) {
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
  protected resetAction(resetCookie = false) {
    if (resetCookie) {
      this.removeCookie(this.appKey)
    }

    this.refreshAuthData()
    // redirect login page.
    if (this.router.currentRoute.value.path !== '/login') {
      this.router.push('/login')
    }
  }

  /**
   * refresh auth data.
   * @return {void}
   */
  protected refreshAuthData() {
    this.store.dispatch('auth/getAuthData', { id: null, name: null, authority: {} })
  }

  /**
   * login action.
   * @param {Object} data
   * @return {boolean}
   */
  async login(email: string, password: string) {
    const response = await this.authentication.loginRequest({ email: email, password: password })
    if (response.status !== 200) {
      return false
    } else {
      // 認証情報の設定
      this.store.dispatch('auth/getAuthData', { id: response.data.user.id, name: response.data.user.name, authority: {} })
      this.setCookie(this.appKey, response.data.access_token)

      // homeへ遷移
      this.router.push('/')
      return true
    }
  }

  /**
   * logout action.
   * @return {Object}
   */
  async logout() {
    const response = await this.authentication.logoutRequest(this.addHeaders({ id: this.store.getters['auth/id'], token: this.getCookie(this.appKey) }))
    if (response.status !== 200) {
      return false
    }

    // データの初期化
    this.resetAction(true)
    // homeへ遷移
    this.router.push('/login')
    return true
  }

  /**
   * get specific cookie.
   * @param {string} key
   * @return {string} cookie
   */
  protected getCookie(key: string = '') {
    const targetCookie = document.cookie.split(',').find(value => value.startsWith(`${key}=`))
     // RegExpオブジェクトで置き換え
    return targetCookie === undefined ? '' : targetCookie.replace(new RegExp(`${key}=`, 'g'), '')
  }

  /**
   * set cookie.
   * @param {string} key
   * @param {string} value
   * @return {void}
   */
  protected setCookie(key: string, value: string, minutes: number = 60) {
    document.cookie = `${key}=${value};max-age=${60 * minutes}`
  }

  /**
   * remove cookies.
   * @param {string} key
   * @return {void}
   */
  protected removeCookie(key: string) {
    document.cookie = `${key}=;max-age=0`
  }
}
