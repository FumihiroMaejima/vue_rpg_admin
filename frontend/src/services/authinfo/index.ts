/* eslint-disable @typescript-eslint/no-var-requires */
// import { Ref } from 'vue'
import axios, { AxiosResponse, AxiosError } from 'axios'
import {
  IAppConfig,
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  BaseAddHeaderResponse,
  ServerRequestType,
  AuthAppHeaderOptions
} from '@/types'

const config: IAppConfig = require('@/config/data')

/**
 * get auth user info.
 * @param {BaseAddHeaderResponse} header
 * @return {void}
 */
export const getAuthUserInfo = async (
  options: AuthAppHeaderOptions
): Promise<ServerRequestType> => {
  axios.defaults.withCredentials = true
  return await axios
    .get(config.endpoint.authinfo.authInfomation, { headers: options.headers })
    .then((response: AxiosResponse<any>) => {
      return { data: response.data, status: response.status }
    })
    .catch((error: AxiosError<any>) => {
      // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
      return {
        data: error,
        status: error.response ? error.response.status : 401
      }
    })
    .finally(() => {
      options.callback()
    })
}
