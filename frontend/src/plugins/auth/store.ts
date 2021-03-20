/* eslint-disable */
import { ActionTree, GetterTree, MutationTree, ActionContext } from 'vuex'
import { RootState, AuthState } from '@/types'

const state = () => ({
  name: null,
  id: null,
  authority: [] as string[]
})

const getters: GetterTree<AuthState, RootState> = {
  name: (state: AuthState) => state.name,
  id: (state: AuthState) => state.id,
  authority: (state: AuthState) => state.authority
}

const actions: ActionTree<AuthState, RootState> = {
  getAuthData({ commit }: ActionContext<AuthState, RootState>, payload: AuthState) {
    commit('setAuthData', payload)
  },

  refreshAuthData({ commit }: ActionContext<AuthState, RootState>) {
    commit('setRefreshAuthData')
  }
}

const mutations: MutationTree<AuthState> = {
  setAuthData(state: AuthState, payload: AuthState) {
    Object.keys(payload).forEach((element) => {
      state[element] = payload[element]
    })
  },

  setRefreshAuthData(state: AuthState) {
    state.id = null
    state.name = null
    state.authority = []
  }
}

export default {
  namespaced: true,
  state: state,
  getters: getters,
  actions: actions,
  mutations: mutations
}
