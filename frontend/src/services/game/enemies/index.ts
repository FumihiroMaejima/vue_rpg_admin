/* eslint-disable @typescript-eslint/no-var-requires */
/* eslint-disable @typescript-eslint/camelcase */
import { reactive, InjectionKey } from 'vue'
import axios, { AxiosResponse, AxiosError } from 'axios'
import {
  IAppConfig,
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
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

export type CreateEnemiesData = Record<
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
    field: 'level',
    header: 'Level',
    editable: true,
    type: 'text',
    style: 'width:10%'
  },
  {
    identifier: 'id',
    field: 'hp',
    header: 'HP',
    editable: true,
    type: 'text',
    style: 'width:10%'
  },
  {
    identifier: 'id',
    field: 'mp',
    header: 'MP',
    editable: true,
    type: 'text',
    style: 'width:10%'
  },
  {
    identifier: 'id',
    field: 'offence',
    header: 'Offence',
    editable: true,
    type: 'text',
    style: 'width:10%'
  },
  {
    identifier: 'id',
    field: 'defense',
    header: 'Defense',
    editable: true,
    type: 'text',
    style: 'width:10%'
  },
  {
    identifier: 'id',
    field: 'speed',
    header: 'Speed',
    editable: true,
    type: 'text',
    style: 'width:10%'
  },
  {
    identifier: 'id',
    field: 'magic',
    header: 'Magic',
    editable: true,
    type: 'text',
    style: 'width:10%'
  }
]

export const toastData: ToastData = {
  severity: 'success',
  summary: 'Summary Message',
  detail: 'Detail Message.',
  life: 5000
}

// TODO make data model
const enemyData = {
  id: 0,
  name: '',
  level: 0,
  hp: 0,
  mp: 0,
  offence: 0,
  defense: 0,
  speed: 0,
  magic: 0
}

export type EnemyType = typeof enemyData
export type EnemyTypeKeys = keyof EnemyType
export type EnemyTextKeys = Extract<EnemyTypeKeys, 'name'>
export type EnemyNumberKeys = Exclude<EnemyTypeKeys, 'id' | EnemyTextKeys>
export type EnemySelectKeys = Exclude<EnemyTypeKeys, EnemyTextKeys | 'id'>

export const useState = () => {
  const state = reactive({
    toast: { ...toastData },
    // permissions: [] as SelectBoxType[],
    enemies: [] as EnemyType[]
  })

  /**
   * get toast
   * @return {ToastData} state.toast
   */
  const getToastData = () => {
    return state.toast
  }

  /**
   * return enemies data
   * @return {EnemyType[]} state.members
   */
  const getEnemies = () => {
    return state.enemies
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
   * insert enemy data to state
   * @param {EnemyType[]} value
   * @return {void}
   */
  const setEnemies = (value: EnemyType[]) => {
    state.enemies = value
  }

  /**
   * set initial data of state
   * @return {void}
   */
  const resetState = () => {
    state.toast = { ...toastData }
    state.enemies = []
    // state.permissions = []
  }

  /**
   * update enemies name
   * @param {number} id
   * @param {string} key
   * @param {string} value
   * @return {void}
   */
  const updateStateTextValue = (
    id: number,
    key: EnemyTextKeys,
    value: string
  ) => {
    /* eslint-disable-next-line @typescript-eslint/no-non-null-assertion */
    state.enemies.find((enemy) => enemy.id === id)![key] = value
  }

  /**
   * update enemies number value
   * @param {number} id
   * @param {string} key
   * @param {number} value
   * @return {Promise<ServerRequestType>}
   */
  const updateStateNumberValue = (
    id: number,
    key: EnemyNumberKeys,
    value: number
  ) => {
    /* eslint-disable-next-line @typescript-eslint/no-non-null-assertion */
    state.enemies.find((enemy) => enemy.id === id)![key] = value
  }

  /**
   * run update enemy request.
   * @param {number} id
   * @param {string} key
   * @param {AuthAppHeaderOptions} options
   * @return {void}
   */
  const updateEnemiesRequest = async (
    id: number,
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    let result = { data: {}, status: 0 } as ServerRequestType
    const index = state.enemies.findIndex((enemy) => enemy.id === id)
    if (index === -1) {
      setToastData(
        'error',
        '敵キャラクター情報更新失敗エラー',
        '存在しない敵キャラクターです。'
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
    const url = config.endpoint.game.enemies.enemy.replace(/:id/g, String(id))
    await axios
      .patch(url, { ...state.enemies[index] }, { headers: options.headers })
      .then((response: AxiosResponse<any>) => {
        msg.severity = 'success'
        msg.summary = '敵キャラクター情報更新'
        msg.detail = 'メンバー情報を更新しました。'

        result = { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        msg.severity = 'error'
        msg.summary = '敵キャラクター情報更新失敗エラー'
        msg.detail = '敵キャラクター情報の更新に失敗しました。'

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
   * get enemies data request.
   * @param {BaseAddHeaderResponse} header
   * @return {void}
   */
  const getEnemiesRequest = async (
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .get(config.endpoint.game.enemies.enemies, {
        headers: options.headers
      })
      .then((response: AxiosResponse<any>) => {
        // 敵キャラクターの設定
        setEnemies(response.data.data)
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          '敵キャラクター情報取得エラー',
          '敵キャラクター情報の取得に失敗しました。'
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
  const downloadEnemiesCSVRequest = async (
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .get(config.endpoint.game.enemies.csv, {
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
   * downlaoad template file request.
   * @param {BaseAddHeaderResponse} header
   * @return {void}
   */
  const downloadTemplateRequest = async (
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .get(config.endpoint.game.enemies.template, {
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
          'テンプレートファイル出力成功',
          'テンプレートファイルをダウンロードしました。'
        )

        return { data: {}, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          'テンプレートダウンロードエラー',
          'テンプレートファイルのダウンロードに失敗しました。'
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
   * inport enemies by file request.
   * @param {CreateEnemiesData} data
   * @param {AuthAppHeaderOptions} options
   * @return {Promise<ServerRequestType>}
   */
  const importEnemiesRequest = async (
    data: FormData,
    // data: CreateEnemiesData,
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    const headers = { ...options.headers }
    // Content-Typeの書き換え
    headers['Content-Type'] = 'multipart/form-data'
    return await axios
      .post(config.endpoint.game.enemies.template, data, {
        headers: headers
      })
      .then((response: AxiosResponse<any>) => {
        setToastData(
          'success',
          '敵キャラクターインポート成功',
          '敵キャラクターをインポートしました。'
        )
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          '敵キャラクターインポートエラー',
          '敵キャラクターのインポートに失敗しました。'
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
   * create enemy request.
   * @param {CreateEnemiesData} data
   * @param {AuthAppHeaderOptions} options
   * @return {Promise<ServerRequestType>}
   */
  const createEnemiesRequest = async (
    data: CreateEnemiesData,
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .post(config.endpoint.game.enemies.create, data, {
        headers: options.headers
      })
      .then((response: AxiosResponse<any>) => {
        setToastData(
          'success',
          '敵キャラクター作成成功',
          '敵キャラクターを新規作成しました。'
        )
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          '敵キャラクター作成エラー',
          '敵キャラクターの新規作成に失敗しました。'
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
   * remove enemy request.
   * @param {number} id
   * @param {AuthAppHeaderOptions} options
   * @return {Promise<ServerRequestType>}
   */
  const removeEnemiesRequest = async (
    ids: number[],
    options: AuthAppHeaderOptions
  ): Promise<ServerRequestType> => {
    axios.defaults.withCredentials = true
    return await axios
      .delete(config.endpoint.game.enemies.delete, {
        data: { enemies: ids },
        headers: options.headers
      })
      .then((response: AxiosResponse<any>) => {
        setToastData(
          'success',
          '敵キャラクター削除成功',
          '選択した敵キャラクターを削除しました。'
        )
        return { data: response.data.data, status: response.status }
      })
      .catch((error: AxiosError<any>) => {
        // for check console.error('axios error' + JSON.stringify(error.message, null, 2))
        setToastData(
          'error',
          '敵キャラクター削除エラー',
          '敵キャラクターの削除に失敗しました。'
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
    getEnemies,
    setEnemies,
    resetState,
    updateStateTextValue,
    updateStateNumberValue,
    updateEnemiesRequest,
    getEnemiesRequest,
    downloadEnemiesCSVRequest,
    downloadTemplateRequest,
    importEnemiesRequest,
    createEnemiesRequest,
    removeEnemiesRequest
  }
}

// get return type of a function type
export type GameEnemiesStateType = ReturnType<typeof useState>
export const EnemiesStateKey: InjectionKey<GameEnemiesStateType> = Symbol(
  'gameEnemiesState'
)
