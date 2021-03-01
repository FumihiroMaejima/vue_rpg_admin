export interface IAppConfig {
  [key: string]: string | string[] | NoticeData[] | AuthEndpoint | EndpointType
  headerName: string
  headerContents: string[]
  noticeData: NoticeData[]
  endpoint: EndpointType
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

export type EndpointType = {
  [key: string]: string | AuthInfoServiceEndipont | MembersServiceEndipont
  authinfo: AuthInfoServiceEndipont
  members: MembersServiceEndipont
}

export type AuthInfoServiceEndipont = {
  [key: string]: string
  AUTH_INFO: string
}

export type MembersServiceEndipont = {
  [key: string]: string
  MEMBERS: string
}

export type TableColumnSetting<T = any> = {
  field: string
  header: string
  type: 'text' | 'select'
  items?: T[]
  itemText?: string
  itemValue?: string
}
