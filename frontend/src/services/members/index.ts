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
import { ToastData, SelectBoxType } from '@/types/components/index'
// import AuthApp from '@/plugins/auth/authApp'

const config: IAppConfig = require('@/config/data')

export const roleItems: SelectBoxType[] = [
  { text: 'role1', value: 1 },
  { text: 'role2', value: 2 },
  { text: 'role3', value: 3 },
  { text: 'role4', value: 4 },
  { text: 'role5', value: 5 }
]

export const tableSetting: TableColumnSetting<SelectBoxType>[] = [
  {
    identifier: 'id',
    field: 'id',
    header: 'ID',
    editable: false,
    type: 'text'
  },
  {
    identifier: 'id',
    field: 'name',
    header: 'Name',
    editable: true,
    type: 'text'
  },
  {
    identifier: 'id',
    field: 'email',
    header: 'Email',
    editable: true,
    type: 'text'
  },
  {
    identifier: 'id',
    field: 'roleId',
    header: 'Role',
    editable: true,
    type: 'select',
    // items: roleItems,
    items: [] as SelectBoxType[],
    itemText: 'text',
    itemValue: 'value'
  }
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
export type MembersTypeKeys = keyof MembersType
export type MembersTextKeys = Exclude<MembersTypeKeys, 'roleId' | 'id'>
export type MembersSelectKeys = Exclude<MembersTypeKeys, MembersTextKeys | 'id'>
// export type MembersTypeKeysTest = Omit<MembersType, 'name'>

export const useState = () => {
  const state = reactive({
    toast: { ...toastData },
    roles: [] as SelectBoxType[],
    members: [] as MembersType[]
  })

  /**
   * get toast
   * @return {ToastData} state.toast
   */
  const getToastData = () => {
    return state.toast
  }

  /**
   * return members data
   * @return {MembersType[]} state.members
   */
  const getMembers = () => {
    return state.members
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
   * set role list
   * @param {SelectBoxType[]} value
   * @return {void}
   */
  const setRoles = (value: SelectBoxType[]) => {
    state.roles = value
  }

  /**
   * insert members data to state
   * @param {MembersType[]} value
   * @return {void}
   */
  const setMembers = (value: MembersType[]) => {
    state.members = value
  }

  /**
   * set initial data of state
   * @return {void}
   */
  const resetState = () => {
    state.toast = { ...toastData }
    state.roles = []
    state.members = []
  }

  /**
   * update memebers name
   * @param {number} id
   * @param {string} key
   * @param {string} value
   * @return {void}
   */
  const updateMembersTextValue = (
    id: number,
    key: MembersTextKeys,
    value: string
  ) => {
    state.members.find((member) => member.id === id)![key] = value
  }

  /**
   * run update text request.
   * @param {number} id
   * @param {string} key
   * @param {AuthAppHeaderOptions} options
   * @return {void}
   */
  const updateMembersData = async (
    id: number,
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    let result = { data: {}, status: 0 } as ServerRequestType
    const index = state.members.findIndex((member) => member.id === id)
    if (index === -1) {
      setToastData(
        'error',
        'メンバー情報更新失敗エラー',
        '存在しないメンバーです。'
      )
      result.status = 404
      return result
    }

    const msg = {
      severity: '',
      summary: '',
      detail: ''
    }

    axios.defaults.withCredentials = true
    const url = config.endpoint.members.member.replace(/:id/g, String(id))
    await axios
      .patch(url, { ...state.members[index] }, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        msg.severity = 'success'
        msg.summary = 'メンバー情報更新'
        msg.detail = 'メンバー情報を更新しました。'

        result = { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        msg.severity = 'error'
        msg.summary = 'メンバー情報更新失敗エラー'
        msg.detail = 'メンバー情報の更新に失敗しました。'

        result = {
          data: error,
          status: error.response ? error.response.status : 500
        }
      })
      .finally(() => {
        setToastData(msg.severity, msg.summary, msg.detail)
        options.callback()
      })

    return result
  }

  /**
   * update memebers role id
   * @param {number} id
   * @param {string} key
   * @param {number} value
   * @return {void}
   */
  const updateMembersRole = (
    id: number,
    key: MembersSelectKeys,
    value: number
  ) => {
    state.members.find((member) => member.id === id)![key] = value
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
      .get(config.endpoint.members.members, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        // メンバーの設定
        setMembers(response.data.data)
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

  const getRoles = async (
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .get(config.endpoint.members.roles, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        // 権限リストの設定
        setRoles(response.data.data)
        // setMembers(response.data.data)
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          '権限情報取得エラー',
          '権限情報の取得に失敗しました。'
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
    getToastData,
    setToastData,
    setRoles,
    setMembers,
    resetState,
    updateMembersTextValue,
    updateMembersData,
    updateMembersRole,
    getMembersData,
    getRoles
  }
}

// get return type of a function type
export type MembersStateType = ReturnType<typeof useState>
export const MembersStateKey: InjectionKey<MembersStateType> = Symbol(
  'membersState'
)
