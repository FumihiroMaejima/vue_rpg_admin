export interface IAppConfig {
  [key: string]: string | string[] | NoticeData[]
  headerName: string
  headerContents: string[]
  noticeData: NoticeData[]
}

export type NoticeData = {
  [key: string]: string
  title: string
  date: string
}
