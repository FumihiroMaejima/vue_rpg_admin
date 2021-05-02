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

export type CreateCharactersData = Record<
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

const characterData = {
  id: 0,
  name: '',
  code: '',
  detail: '',
  permissions: [] as number[]
}

export type CharacterType = typeof characterData
export type CharacterTypeKeys = keyof CharacterType
export type CharacterTextKeys = Exclude<CharacterTypeKeys, 'permissions' | 'id'>
export type CharacterSelectKeys = Exclude<
  CharacterTypeKeys,
  CharacterTextKeys | 'id'
>

export const useState = () => {
  const state = reactive({
    toast: { ...toastData },
    permissions: [] as SelectBoxType[],
    roles: [] as CharacterType[]
  })

  /**
   * get toast
   * @return {ToastData} state.toast
   */
  const getToastData = () => {
    return state.toast
  }

  /**
   * return characters data
   * @return {CharacterType[]} state.members
   */
  const getCharacters = () => {
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
   * @param {CharacterType[]} value
   * @return {void}
   */
  const setCharacters = (value: CharacterType[]) => {
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
   * update characters name
   * @param {number} id
   * @param {string} key
   * @param {string} value
   * @return {void}
   */
  const updateCharactersTextValue = (
    id: number,
    key: CharacterTextKeys,
    value: string
  ) => {
    state.roles.find((role) => role.id === id)![key] = value
  }

  /**
   * run update role request.
   * @param {number} id
   * @param {string} key
   * @param {AuthAppHeaderOptions} options
   * @return {void}
   */
  const updateCharactersRequest = async (
    id: number,
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    let result = { data: {}, status: 0 } as ServerRequestType
    const index = state.roles.findIndex((role) => role.id === id)
    if (index === -1) {
      setToastData(
        'error',
        'キャラクター情報更新失敗エラー',
        '存在しないキャラクターです。'
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
        msg.summary = 'キャラクター情報更新'
        msg.detail = 'メンバー情報を更新しました。'

        result = { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        msg.severity = 'error'
        msg.summary = 'キャラクター情報更新失敗エラー'
        msg.detail = 'キャラクター情報の更新に失敗しました。'

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
   * get characters data request.
   * @param {BaseAddHeaderResponse} header
   * @return {void}
   */
  const getCharactersRequest = async (
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .get(config.endpoint.roles.roles, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        // キャラクターの設定
        setCharacters(response.data.data)
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          'キャラクター情報取得エラー',
          'キャラクター情報の取得に失敗しました。'
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
   * @return {void}
   */
  const downloadCharactersCSV = async (
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
   * create role request.
   * @param {CreateCharactersData} data
   * @param {AuthAppHeaderOptions} options
   * @return {Promise<ServerRequestType>}
   */
  const createCharacters = async (
    data: CreateCharactersData,
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .post(config.endpoint.roles.create, data, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        setToastData(
          'success',
          'キャラクター作成成功',
          'キャラクターを新規作成しました。'
        )
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          'キャラクター作成エラー',
          'キャラクターの新規作成に失敗しました。'
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
  const removeCharacters = async (
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
          'キャラクター削除成功',
          '選択したキャラクターを削除しました。'
        )
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          'キャラクター削除エラー',
          'キャラクターの削除に失敗しました。'
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
    getToastData,
    setToastData,
    getCharacters,
    setCharacters,
    resetState,
    updateCharactersTextValue,
    updateCharactersRequest,
    getCharactersRequest,
    downloadCharactersCSV,
    createCharacters,
    removeCharacters
  }
}

// get return type of a function type
export type GameCharactersStateType = ReturnType<typeof useState>
export const CharactersStateKey: InjectionKey<GameCharactersStateType> = Symbol(
  'gameCharactersState'
)
