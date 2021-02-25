/* eslint-disable */
import { Router } from 'vue-router'
import { Store } from 'vuex'
import Authentication from '@/plugins/auth/authentication'
const config: IAppConfig = require('@/config/data')
import { AuthState, RootState, HeaderDataState, AuthEndpoint, IAppConfig, BaseAddHeaderResponse, AuthAppHeaderOptions } from '@/types'

export default class AuthApp {
  private router: Router
  private store: Store<RootState>
  private endpoint: AuthEndpoint
  private authentication: Authentication
  private appKey: string

  constructor(router: Router, store: Store<RootState>) {
    this.router = router
    this.store = store
    this.endpoint = config.authEndpoint
    this.authentication = new Authentication(this.endpoint)
    this.appKey = 'application_token'
  }

  /**
   * return authenticated id
   * @return {number} id
   */
  public getAuthId():AuthState['id'] {
    return this.store.getters['auth/id']
  }

  /**
   * return authenticated name
   * @return {string} name
   */
  public getAuthName():AuthState['name'] {
    return this.store.getters['auth/name']
  }

  /**
   * return authenticated authority
   * @return {Object} authority
   */
  public getAuthAuthority(): AuthState['authority'] {
    return this.store.getters['auth/authority']
  }

  /**
   * login action.
   * @param {Object} data
   * @return {boolean}
   */
  public async login(email: string, password: string): Promise<boolean> {
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
  public async logout(): Promise<boolean> {
    const response = await this.authentication.logoutRequest(this.getHeaderOptions().headers)
    const result = response.status === 200

    // データの初期化
    this.resetAction(true)
    // login画面へ遷移
    this.router.push('/login')
    return result
  }

  /**
   * get authApp header options.
   * @return {AuthAppHeaderOptions} { headers, callback }
   */
  public getHeaderOptions(): AuthAppHeaderOptions {
    const token: string = this.getCookie(this.appKey)
    // tokenが無い場合はデータを初期化する
    if (token === '') {
      this.resetAction()
    }

    this.restoreToken()

    return {
      headers: this.addHeaders({ id: this.store.getters['auth/id'], token: token }),
      callback: () => this.restoreToken(token, true)
    }
  }

  /**
   * check authenticated data.
   * @return {boolean}
   */
  public async checkAuthenticated(): Promise<boolean> {
    const token: string = this.getCookie(this.appKey)
    // tokenが無い場合はデータを初期化する
    if (token === '') {
      this.resetAction()
      return false
    }
    this.restoreToken()

    const isAuth = await this.authInstance(this.store.getters['auth/id'], token).then((response) => {
      // 認証情報が無い場合
      if (!response.id) {
        this.resetAction(true)
        return false
      }

      // 取得した認証情報の設定
      this.store.dispatch('auth/getAuthData', { id: response.id, name: response.name, authority: {} })
      this.restoreToken(token, true)
      return true
    })
    return isAuth
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
  protected async authInstance(id: AuthState['id'], token: HeaderDataState['token']) {
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
  }

  /**
   * refresh auth data.
   * @return {void}
   */
  protected refreshAuthData() {
    this.store.dispatch('auth/getAuthData', { id: null, name: null, authority: {} })
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
  protected setCookie(key: string, value: string, minutes: number = 10) {
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

  /**
   * restore or remove cookie.
   * @param {boolean} isRestore
   * @return {void}
   */
  protected restoreToken(token: string = '', isRestore: boolean = false) {
    isRestore ? this.setCookie(this.appKey, token) : this.removeCookie(this.appKey)
  }
}
