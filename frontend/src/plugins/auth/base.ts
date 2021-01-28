/* eslint-disable */
import Vue from 'vue'
// import store from 'vuex'
import { Router } from 'vue-router'
import Authentication from '@/plugins/auth/authentication'
const config: IAppConfig = require('@/config/data')
import { AuthState, HeaderDataState, AuthEndpoint, IAppConfig } from '@/types'
export default class Base {
  router: Router
  endpoint: AuthEndpoint
  authentication: Authentication

  constructor(router: Router) {
    this.router = router
    this.endpoint = config.authEndpoint
    this.authentication = new Authentication(this.endpoint)
  }

  addHeaders(data: HeaderDataState) {
    return {
      Authorization: `Bearer ${data.token ? data.token : ''}`,
      'X-Auth-ID': data.id ? data.id : ''
    }
  }

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
}
