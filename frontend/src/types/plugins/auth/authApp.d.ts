import { AuthEndpoint } from '@/types/config/data'
import { IAuthentication } from '@/types/plugins/auth/authentication'
import { authentication } from '@/plugins/auth/authentication'
import { Router } from 'vue-router'

export interface IAuthApp {
  [key: string]: Router | AuthEndpoint | authentication
  router: Router
  endpoint: AuthEndpoint
  authentication: typeof authentication
}

export type HeaderDataState = {
  id: number | null
  token: string | null
}

export type BaseAddHeaderResponse = {
  Authorization: string
  'X-Auth-ID': number | string
}
