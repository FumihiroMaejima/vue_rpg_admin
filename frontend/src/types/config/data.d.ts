export interface IAppConfig {
  [key: string]: string | string[] | NoticeData[] | AuthEndpoint
  headerName: string
  headerContents: string[]
  noticeData: NoticeData[]
  authEndpoint: AuthEndpoint
}

export type NoticeData = {
  [key: string]: string
  title: string
  date: string
}

export type AuthEndpoint = {
  [key: string]: string
  AUTH_LOGIN: string
  AUTH_LOGOUT: string
  AUTH_SELF: string
}
