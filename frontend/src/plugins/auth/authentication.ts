/* eslint-disable */
import axios, { AxiosResponse } from 'axios'
// import { IAuthConfig } from '@/types'
// const config: IAuthConfig = require('@/config/app')
import { BaseAddHeaderResponse, AuthEndpoint } from '@/types'

export default class Authentication {
  options: AuthEndpoint

  constructor(options: AuthEndpoint) {
    this.options = options
  }

  async getUser(header: BaseAddHeaderResponse) {
    axios.defaults.withCredentials = true
    return await axios
      .post(this.options.AUTH_SELF, {}, { headers: header })
      .then((response: AxiosResponse<any>) => {
        return { data: response.data, status: response.status}
      })
      .catch((error: any) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        return { data: error, status: error.response.status }
      })
  }

  async authority(meta: any): Promise<any> {
    return { data: true }
  }
}
