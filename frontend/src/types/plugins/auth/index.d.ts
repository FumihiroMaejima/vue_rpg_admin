export * from '@/types/plugins/auth/authentication'
export * from '@/types/plugins/auth/base'

import { Store, StoreOptions } from 'vuex'
import { Router } from 'vue-router'

export type AuthState = {
  [key: string]: string | number | object | null
  name: string | null
  id: number | null
  authority: object | null
}

export type AuthOption = {
  store: Store<AuthState>
  router: Router
  option: any
}
