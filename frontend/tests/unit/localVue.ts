/* eslint-disable @typescript-eslint/no-var-requires */
import App, { createApp, ref, ComponentPublicInstance } from 'vue'
import AppComponent from './App.vue'
import router from '@/router'
import store from '@/store'
import { shallowMount, VueWrapper, MountingOptions } from '@vue/test-utils'

// 現在Vue3ではcreateLocalVueが使えない。

// axiosのモック
/* import axios from 'axios'
jest.mock('axios')

// axiosのmockを作成
const localClient = (axios as any)
localClient.get.mockResolvedValue({data: {key: 'value'}}) */

export function getRouter() {
  return router
}

export function getStore() {
  return store
}

export function localVueInstance() {
  // wip
  // const instace = new VueWrapper<ComponentPublicInstance>()
}
