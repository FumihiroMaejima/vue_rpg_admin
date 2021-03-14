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
import ToastService from 'primevue/toastservice'
import { LinerLoadingKey } from '@/keys'
import { IAppConfig } from '@/types'

const config: IAppConfig = require('@/config/data')
const loading = ref<boolean>(false)

const app = createApp(App)

app.config.globalProperties.$AppConfig = config
app.provide(LinerLoadingKey, loading)

// createApp(App)
app.use(store)
app.use(router)
app.use(auth, { router, store, loading })
app.use(PrimeVue)
app.use(ToastService)
app.mount('#app')

/* createApp(App)
  .use(store)
  .use(router)
  .mount('#app') */

require('@/assets/scss/App.scss')
