/* eslint-disable @typescript-eslint/no-var-requires */
import { createApp, ComponentPublicInstance } from 'vue'
import { App } from '@vue/runtime-core'
import { Store } from 'vuex'
import { Router } from 'vue-router'
import { shallowMount, VueWrapper, MountingOptions } from '@vue/test-utils'
import { GlobalMountOptions } from '@vue/test-utils/dist/types'
import AppComponent from '@/App.vue'
import router from '@/router'
import store from '@/store'
import axios, { AxiosStatic } from 'axios'
import { IAppConfig, RootState } from '@/types'
import 'jest'
const config: IAppConfig = require('@/config/data')

// 現在Vue3ではcreateLocalVueが使えない。→廃止になった。

// axiosのモック deprecated
/* import axios from 'axios'
jest.mock('axios')

// axiosのmockを作成
const localClient = (axios as any)
localClient.get.mockResolvedValue({data: {key: 'value'}}) */

// axios mockの実装方法
/* import axios, { AxiosStatic } from 'axios'
jest.mock('axios')
const client = axios as jest.Mocked<AxiosStatic>
client.get.mockResolvedValue({ data: { key: 'value' } }) */

/**
 * get axios mock.
 * @return {jest.Mocked<AxiosStatic>}
 */
export function getAxiosMock() {
  return axios as jest.Mocked<AxiosStatic>
}

/**
 * get app config.
 * @return {IAppConfig}
 */
export function getAppConfig(): IAppConfig {
  return config
}

/**
 * get router.
 * @return {Router} router
 */
export function getRouter() {
  return router
}

/**
 * get store.
 * @return {Store<RootState>}
 */
export function getStore() {
  return store
}

export function localVueInstance(): App<Element> {
  // wip
  // const instace = new VueWrapper<ComponentPublicInstance>()
  const app = createApp(AppComponent)
  app.config.globalProperties.$AppConfig = config
  // app.mount('#app')
  return app
}

/**
 * return global mount options.
 * see https://next.vue-test-utils.vuejs.org/api/#global
 * @return {GlobalMountOptions} options
 */
export function localGlobalOptions(): GlobalMountOptions {
  const options = {
    // plugins:
    config: { globalProperties: { $AppConfig: config } }
    // mocks
    // provide
    // components
    // stubs
  }
  return options
}

// export type GetOptionsByKeyType<T = keyof GlobalMountOptions> = (keyName: T) => GlobalMountOptions[keyof GlobalMountOptions]

/**
 * get global option property by key name.
 * @param {keyof GlobalMountOptions} keyName
 * @return {GlobalMountOptions[keyof GlobalMountOptions]} options[keyName]
 */
export const getLocalOptionsByKeys = (
  keyName: keyof GlobalMountOptions = 'config'
): GlobalMountOptions[keyof GlobalMountOptions] => {
  const options: GlobalMountOptions = {
    // plugins:
    config: { globalProperties: { $AppConfig: config } }
    // mocks
    // provide
    // components
    // stubs
  }
  return options[keyName]
}
