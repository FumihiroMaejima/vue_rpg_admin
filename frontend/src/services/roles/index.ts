/* eslint-disable @typescript-eslint/no-var-requires */
/* eslint-disable @typescript-eslint/camelcase */
import { Ref, reactive, InjectionKey } from 'vue'
import axios, { AxiosResponse, AxiosError } from 'axios'
import {
  IAppConfig,
  BaseAddHeaderResponse,
  ServerRequestType,
  AuthAppHeaderOptions
} from '@/types'
import { TableColumnSetting } from '@/types/config/data'
import { ToastData, SelectBoxType } from '@/types/applications/index'
import {
  validateName,
  validateSelectBoxNumberValue,
  validateRoleCode,
  validateRoleDetail,
  validateMultipleNumberValue
} from '@/util/validation'
import { makeDataUrl, downloadFile } from '@/util'

const config: IAppConfig = require('@/config/data')

export const editableRole = ['master', 'administrator']

export const formSchema = {
  name(value: string): string {
    return validateName(value)
  },
  code(value: string): string {
    return validateRoleCode(value)
  },
  detail(value: string): string {
    return validateRoleDetail(value)
  },
  permissions(value: number[]): string {
    return validateMultipleNumberValue(value)
  }
}

export const removeFormSchema = {
  role(value: number): string {
    return validateSelectBoxNumberValue(value)
  }
}

export type CreateRoleData = Record<
  Exclude<keyof typeof formSchema, 'permissions'>,
  string
> &
  Record<'permissions', number[]>

export const tableSetting: TableColumnSetting<SelectBoxType>[] = [
  {
    identifier: 'id',
    field: 'id',
    header: 'ID',
    editable: false,
    type: 'text',
    style: 'width:10%'
  },
  {
    identifier: 'id',
    field: 'name',
    header: 'Name',
    editable: true,
    type: 'text',
    style: 'width:30%'
  },
  {
    identifier: 'id',
    field: 'code',
    header: 'Code',
    editable: true,
    type: 'text',
    style: 'width:30%'
  },
  {
    identifier: 'id',
    field: 'detail',
    header: 'Detail',
    editable: true,
    type: 'text',
    style: 'width:30%'
  },
  {
    identifier: 'id',
    field: 'permissions',
    header: 'Permission',
    editable: true,
    type: 'select',
    style: 'width:30%',
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

const rolesData = {
  id: 0,
  name: '',
  code: '',
  detail: '',
  permissions: [] as number[]
}

export type RolesType = typeof rolesData
export type RolesTypeKeys = keyof RolesType
export type RolesTextKeys = Exclude<RolesTypeKeys, 'permissions' | 'id'>
export type RolesSelectKeys = Exclude<RolesTypeKeys, RolesTextKeys | 'id'>
// export type MembersTypeKeysTest = Omit<RolesType, 'name'>

export const useState = () => {
  const state = reactive({
    toast: { ...toastData },
    permissions: [] as SelectBoxType[],
    roles: [] as RolesType[]
  })

  /**
   * get toast
   * @return {ToastData} state.toast
   */
  const getToastData = () => {
    return state.toast
  }

  /**
   * return roles data
   * @return {RolesType[]} state.members
   */
  const getRoles = () => {
    return state.roles
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
   * set permissions list
   * @param {SelectBoxType[]} value
   * @return {void}
   */
  const getPermissions = (value: SelectBoxType[]) => {
    state.permissions = value
  }

  /**
   * insert role data to state
   * @param {RolesType[]} value
   * @return {void}
   */
  const setRoles = (value: RolesType[]) => {
    state.roles = value
  }

  /**
   * set initial data of state
   * @return {void}
   */
  const resetState = () => {
    state.toast = { ...toastData }
    state.roles = []
    state.permissions = []
  }

  /**
   * update roles name
   * @param {number} id
   * @param {string} key
   * @param {string} value
   * @return {void}
   */
  const updateStateTextValue = (
    id: number,
    key: RolesTextKeys,
    value: string
  ) => {
    state.roles.find((role) => role.id === id)![key] = value
  }

  /**
   * update role`s permission ids
   * @param {number} id
   * @param {string} key
   * @param {number[]} value
   * @return {void}
   */
  const updateStateSelectValue = (
    id: number,
    key: RolesSelectKeys,
    value: number[]
  ) => {
    state.roles.find((role) => role.id === id)![key] = value
  }

  /**
   * run update text request.
   * @param {number} id
   * @param {string} key
   * @param {AuthAppHeaderOptions} options
   * @return {void}
   */
  const updateRolesDataRequest = async (
    id: number,
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    let result = { data: {}, status: 0 } as ServerRequestType
    const index = state.roles.findIndex((role) => role.id === id)
    if (index === -1) {
      setToastData(
        'error',
        'ロール情報更新失敗エラー',
        '存在しないロールです。'
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
    const url = config.endpoint.roles.role.replace(/:id/g, String(id))
    await axios
      .patch(url, { ...state.roles[index] }, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        msg.severity = 'success'
        msg.summary = 'ロール情報更新'
        msg.detail = 'メンバー情報を更新しました。'

        result = { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        msg.severity = 'error'
        msg.summary = 'ロール情報更新失敗エラー'
        msg.detail = 'ロール情報の更新に失敗しました。'

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
   * get roles data.
   * @param {BaseAddHeaderResponse} header
   * @return {void}
   */
  const getRolesDataRequest = async (
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .get(config.endpoint.roles.roles, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        // ロールの設定
        setRoles(response.data.data)
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          'ロール情報取得エラー',
          'ロール情報の取得に失敗しました。'
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

  /**
   * downlaoad file request.
   * @param {BaseAddHeaderResponse} header
   * @return {Promise<ServerRequestType>}
   */
  const downloadRolesCSVRequest = async (
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .get(config.endpoint.roles.csv, {
        headers: options.headers,
        responseType: 'blob'
      })
      .then((response: AxiosResponse<any>) => {
        // download
        downloadFile(
          makeDataUrl(response.data, response.headers['content-type']),
          response.headers['content-disposition'].replace(
            'attachment; filename=',
            ''
          )
        )

        setToastData(
          'success',
          'CSVファイル出力成功',
          'ファイルをダウンロードしました。'
        )

        return { data: {}, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          'CSVダウンロードエラー',
          'CSVファイルのダウンロードに失敗しました。'
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

  /**
   * get permissions request.
   * @param {AuthAppHeaderOptions} options
   * @return {Promise<ServerRequestType>}
   */
  const getPermissionsListRequest = async (
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .get(config.endpoint.roles.permissions, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        // 権限リストの設定
        getPermissions(response.data.data)
        // setRoles(response.data.data)
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          '認可情報取得エラー',
          '認可情報の取得に失敗しました。'
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

  /**
   * create role request.
   * @param {CreateRoleData} data
   * @param {AuthAppHeaderOptions} options
   * @return {Promise<ServerRequestType>}
   */
  const createRoleRequest = async (
    data: CreateRoleData,
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .post(config.endpoint.roles.create, data, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        setToastData('success', 'ロール作成成功', 'ロールを新規作成しました。')
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          'ロール作成エラー',
          'ロールの新規作成に失敗しました。'
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

  /**
   * remove role request.
   * @param {number} id
   * @param {AuthAppHeaderOptions} options
   * @return {Promise<ServerRequestType>}
   */
  const removeRoleRequest = async (
    ids: number[],
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .delete(config.endpoint.roles.delete, {
        data: { roles: ids },
        headers: options.headers
      })
      .then((response: AxiosResponse<any>) => {
        setToastData(
          'success',
          'ロール削除成功',
          '選択したロールを削除しました。'
        )
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          'ロール削除エラー',
          'ロールの削除に失敗しました。'
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
    getRoles,
    getToastData,
    setToastData,
    setRoles,
    resetState,
    updateStateTextValue,
    updateStateSelectValue,
    updateRolesDataRequest,
    getRolesDataRequest,
    downloadRolesCSVRequest,
    getPermissionsListRequest,
    createRoleRequest,
    removeRoleRequest
  }
}

// get return type of a function type
export type RolesStateType = ReturnType<typeof useState>
export const RolesStateKey: InjectionKey<RolesStateType> = Symbol('rolesState')
