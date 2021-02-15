/* eslint-disable @typescript-eslint/no-var-requires */
import { Ref } from 'vue'
import axios, { AxiosResponse, AxiosError } from 'axios'
import { IAppConfig, BaseAddHeaderResponse, ServerRequestType } from '@/types'

const config: IAppConfig = require('@/config/data')

/**
 * get auth user info.
 * @param {BaseAddHeaderResponse} header
 * @return {void}
 */
export const getMembers = async (
  header: BaseAddHeaderResponse
): Promise<ServerRequestType> => {
  axios.defaults.withCredentials = true
  return await axios
    .get(config.endpoint.members.MEMBERS, { headers: header })
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
}
