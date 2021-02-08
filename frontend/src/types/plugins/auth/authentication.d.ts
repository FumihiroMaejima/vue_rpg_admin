import { AxiosError } from 'axios'

export interface IAuthentication {
  [key: string]: AuthEndpoint
  options: AuthEndpoint
}

export type GetUserFunctionResponse = {
  [key: string]: any | AxiosError | number
  data: any | AxiosError
  string: number
}
