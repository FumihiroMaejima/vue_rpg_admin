export * from '@/types/plugins/auth/authentication'
export * from '@/types/plugins/auth/authApp'

import { Ref } from 'vue'
import { Store, StoreOptions } from 'vuex'
import { Router } from 'vue-router'

export type AuthState = {
  [key: string]: string | number | object | null
  name: string | null
  id: number | null
  authority: object | null
}

export type AuthOptions = {
  store: Store<AuthState>
  router: Router
  loading: Ref<boolean>
}
