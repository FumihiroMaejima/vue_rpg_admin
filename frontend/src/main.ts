/* eslint-disable @typescript-eslint/no-var-requires */
import { createApp, ref } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import auth from './plugins/auth'
import PrimeVue from 'primevue/config'
import 'primevue/resources/themes/saga-blue/theme.css'
// import 'primevue/resources/themes/nova/theme.css'
// import 'primevue/resources/themes/nova-alt/theme.css'
import 'primevue/resources/primevue.min.css'
import 'primeicons/primeicons.css'
import 'primeflex/primeflex.css'
import { IAppConfig } from '@/types'

const config: IAppConfig = require('@/config/data')
const option = ref<boolean>(false)

const app = createApp(App)

app.config.globalProperties.$AppConfig = config
app.provide('linerLoading', option)

// createApp(App)
app.use(store)
app.use(router)
app.use(auth, { router, store, option })
app.use(PrimeVue)
app.mount('#app')

/* createApp(App)
  .use(store)
  .use(router)
  .mount('#app') */

require('@/assets/scss/App.scss')
