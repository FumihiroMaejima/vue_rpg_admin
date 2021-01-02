/* eslint-disable @typescript-eslint/no-var-requires */
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import PrimeVue from 'primevue/config'
import 'primeicons/primeicons.css'
import 'primeflex/primeflex.css'
import { IAppConfig } from '@/types'

const config: IAppConfig = require('@/config/data')

const app = createApp(App)

app.config.globalProperties.$AppConfig = config

// createApp(App)
app.use(store)
app.use(router)
app.use(PrimeVue)
app.mount('#app')

/* createApp(App)
  .use(store)
  .use(router)
  .mount('#app') */

require('@/assets/scss/App.scss')
