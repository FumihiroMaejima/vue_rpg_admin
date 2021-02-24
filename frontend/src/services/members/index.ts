/* eslint-disable @typescript-eslint/no-var-requires */
import { Ref, reactive, InjectionKey } from 'vue'
import axios, { AxiosResponse, AxiosError } from 'axios'
import { IAppConfig, BaseAddHeaderResponse, ServerRequestType } from '@/types'
import { TableColumnSetting } from '@/types/config/data'

const config: IAppConfig = require('@/config/data')

export const tableKeys: TableColumnSetting[] = [
  { field: 'id', header: 'ID' },
  { field: 'name', header: 'Name' },
  { field: 'email', header: 'Email' },
  { field: 'roleId', header: 'Role' }
]

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

const membersData = {
  id: 0,
  name: '',
  email: '',
  roleId: 0
}
export type MembersType = typeof membersData

export const useState = () => {
  const state = reactive({
    name: 'test',
    newname: '',
    answered: false,
    clicked: false,
    members: [] as MembersType[]
  })

  const getMembersData = () => {
    return state.members
  }

  const updateName = (newname: string) => {
    const randString = Math.random()
      .toString(32)
      .substring(2)
    state.name = `${newname}_${randString}`
  }
  const updateAnswered = () => {
    state.answered = !state.answered
  }
  const updateClicked = () => {
    state.clicked = true
  }

  const insertMembers = (value: MembersType[]) => {
    state.members = value
  }

  const resetState = () => {
    state.name = 'test'
    state.newname = ''
    state.answered = false
    state.clicked = false
    state.members = []
  }

  /**
   * get auth user info.
   * @param {BaseAddHeaderResponse} header
   * @return {void}
   */
  const getMembers = async (
    header: BaseAddHeaderResponse
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .get(config.endpoint.members.MEMBERS, { headers: header })
      .then((response: AxiosResponse<any>) => {
        // メンバーの設定
        insertMembers(response.data.data)
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        return {
          data: error,
          status: error.response ? error.response.status : 401
        }
      })
  }

  return {
    state,
    getMembersData,
    updateName,
    updateAnswered,
    updateClicked,
    insertMembers,
    resetState,
    getMembers
  }
}

export type StateStore = typeof useState
export const StateKey: InjectionKey<StateStore> = Symbol('StateStore')
