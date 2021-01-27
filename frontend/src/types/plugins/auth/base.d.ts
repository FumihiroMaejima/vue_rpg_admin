export type HeaderDataState = {
  id: number | null
  token: string | null
}

export type BaseAddHeaderResponse = {
  Authorization: string
  'X-Auth-ID': number | string
}
