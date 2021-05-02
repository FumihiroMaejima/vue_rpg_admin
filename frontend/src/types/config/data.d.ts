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
  roles: RolesServiceEndipont
  game: GameTotalEndipont
}

export type AuthInfoServiceEndipont = {
  [key: string]: string
  authInfomation: string
}

export type MembersServiceEndipont = {
  [key: string]: string
  members: string
  csv: string
  member: string
  create: string
  roles: string
}

export type RolesServiceEndipont = {
  [key: string]: string
  roles: string
  csv: string
  role: string
  create: string
  delete: string
  permissions: string
}

export type GameTotalEndipont = {
  [key: string]: string
  characters: GameCharactersServiceEndipont
}

export type GameCharactersServiceEndipont = {
  [key: string]: string
  characters: string
  template: string
  csv: string
}

export type TableTextColumn = {
  identifier: string
  field: string
  header: string
  type: 'text'
  editable: boolean
  style: string
}

export type TableSelectColumn<T = any> = {
  identifier: string
  field: string
  header: string
  type: 'select'
  editable: boolean
  style: string
  items: T[]
  itemText: string
  itemValue: string
}

export type TableColumnSetting<T = any> = TableTextColumn | TableSelectColumn<T>

export type SideBarContentsType = {
  label: string
  icon: string
  items: (
    | {
        label: string
        icon: string
        to: string
      }
    | {
        separator: boolean
      }
  )[]
}
