import { createStore, StoreOptions } from 'vuex'
import { RootState } from '@/types'

const store: StoreOptions<RootState> = {
  strict: process.env.NODE_ENV !== 'production',
  state: {},
  modules: {},
  mutations: {},
  actions: {}
}

export default createStore(store)
