import { AxiosError } from 'axios'

export type GetUserFunctionResponse = {
  [key: string]: any | AxiosError | number
  data: any | AxiosError
  string: number
}
