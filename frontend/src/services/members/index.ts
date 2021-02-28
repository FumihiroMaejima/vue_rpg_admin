/* eslint-disable @typescript-eslint/no-var-requires */
import { Ref, reactive, InjectionKey, inject } from 'vue'
import axios, { AxiosResponse, AxiosError } from 'axios'
import {
  IAppConfig,
  BaseAddHeaderResponse,
  ServerRequestType,
  AuthAppHeaderOptions
} from '@/types'
import { TableColumnSetting } from '@/types/config/data'
import { ToastData } from '@/types/components/index'
// import AuthApp from '@/plugins/auth/authApp'

const config: IAppConfig = require('@/config/data')

export const tableSetting: TableColumnSetting[] = [
  { field: 'id', header: 'ID', type: 'text' },
  { field: 'name', header: 'Name', type: 'text' },
  { field: 'email', header: 'Email', type: 'text' },
  { field: 'roleId', header: 'Role', type: 'text', items: [] }
]

export const toastData: ToastData = {
  severity: 'success',
  summary: 'Summary Message',
  detail: 'Detail Message.',
  life: 5000
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
    toast: { ...toastData },
    members: [] as MembersType[]
  })

  /**
   * return members data
   * @return {MembersType[]} state.members
   */
  const getMembers = () => {
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

  /**
   * insert members data to state
   * @param {MembersType[]} value
   * @return {void}
   */
  const insertMembers = (value: MembersType[]) => {
    state.members = value
  }

  /**
   * set initial data of state
   * @return {void}
   */
  const resetState = () => {
    state.name = 'test'
    state.newname = ''
    state.answered = false
    state.clicked = false
    state.toast = { ...toastData }
    state.members = []
  }

  /**
   * set toast data.
   * @param {string} severity
   * @param {string} summary
   * @param {string} detail
   * @param {number} life
   * @return {void}
   */
  const setToastData = (
    severity = 'success',
    summary = 'summary',
    detail = 'detail',
    life = 5000
  ) => {
    state.toast.severity = severity
    state.toast.summary = summary
    state.toast.detail = detail
    state.toast.life = life
  }

  /**
   * get toast
   * @return {ToastData} state.toast
   */
  const getToastData = () => {
    return state.toast
  }

  /**
   * get auth user info.
   * @param {BaseAddHeaderResponse} header
   * @return {void}
   */
  const getMembersData = async (
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .get(config.endpoint.members.MEMBERS, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        // メンバーの設定
        insertMembers(response.data.data)
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          'メンバー情報取得エラー',
          'メンバー情報の取得に失敗しました。'
        )
        return {
          data: error,
          status: error.response ? error.response.status : 401
        }
      })
      .finally(() => {
        options.callback()
      })
  }

  return {
    state,
    getMembers,
    updateName,
    updateAnswered,
    updateClicked,
    insertMembers,
    resetState,
    setToastData,
    getToastData,
    getMembersData
  }
}

// get return type of a function type
export type MembersStateType = ReturnType<typeof useState>
export const MembersStateKey: InjectionKey<MembersStateType> = Symbol(
  'membersState'
)
