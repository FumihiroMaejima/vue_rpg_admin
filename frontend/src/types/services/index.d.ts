/* eslint-disable @typescript-eslint/no-empty-interface */
import { AxiosResponse, AxiosError } from 'axios'

export type ServerRequestType<T = any> = {
  data:
    | string
    | T
    | AxiosResponse<T>
    | ServerErrorResponseType
    | AxiosError<ServerErrorResponseType>
  status: number
}

export type ServerErrorResponseType = {
  status: number
  errors: string[]
  message: string
}
