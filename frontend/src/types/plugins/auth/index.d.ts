export * from '@/types/plugins/auth/authentication'
export * from '@/types/plugins/auth/authApp'
import { BaseAddHeaderResponse } from '@/types'

import { Ref } from 'vue'
import { Store } from 'vuex'
import { Router } from 'vue-router'

import { RootState } from '@/types'

export type AuthState = {
  [key: string]: string | number | Record<string, any> | null
  name: string | null
  id: number | null
  authority: Record<string, any> | null
}

export type AuthOptions = {
  store: Store<RootState>
  router: Router
  loading: Ref<boolean>
}

export type AuthAppUtils = {
  getHeader: () => BaseAddHeaderResponse
  login: (email: string, password: string) => Promise<boolean>
  logout: () => Promise<boolean>
}
