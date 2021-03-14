/* eslint-disable @typescript-eslint/no-empty-interface */
import axios, { AxiosError } from 'axios'

export type ServerRequestType = {
  [key: string]: string | number | any | AxiosError<any>
  data: any | AxiosError<any>
  status: number
}
