/* eslint-disable */
import { ActionTree, GetterTree, MutationTree } from 'vuex'
import { RootState, AuthState } from '@/types'

const state = () => ({
  name: null,
  id: null,
  authority: {}
})

const getters: GetterTree<AuthState, RootState> = {
  name: (state: AuthState) => state.name,
  id: (state: AuthState) => state.id,
  authority: (state: AuthState) => state.authority
}

const actions: ActionTree<AuthState, RootState> = {
  getAuthData({ commit }: any, payload: AuthState) {
    commit('setAuthData', payload)
  },

  refreshAuthData({ commit }: any) {
    commit('setRefreshAuthData')
  }
}

const mutations: MutationTree<AuthState> = {
  setAuthData(state: any, payload: any) {
    Object.keys(payload).forEach((element) => {
      state[element] = payload[element]
    })
  },

  setRefreshAuthData(state: AuthState) {
    state.id = null
    state.name = null
    state.authority = null
  }
}

export default {
  namespaced: true,
  state: state,
  getters: getters,
  actions: actions,
  mutations: mutations
}
