/* eslint-disable */
import Vue from 'vue'
import { App, provide, createApp, defineComponent, Renderer, CreateAppFunction } from 'vue'
import AppComponent from './App.vue'
// import store from 'vuex'
import router from 'vue-router'
import Authentication from '@/plugins/auth/authentication'
import Base from '@/plugins/auth/base'
import { AuthState, HeaderDataState } from '@/types'
// import cnf from '~/config/config.json'

export default {
  install(app: App<typeof AppComponent>, options: any) {
    const base = new Base(router)
    app.config.globalProperties.$authApp = base
    app.provide('authApp', base)
  }
}

