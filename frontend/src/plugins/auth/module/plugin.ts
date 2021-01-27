// import { Store } from 'vuex'
import rootModule from './store'
const namespace = 'subModules'

export default ({ store }: any) => {
  store.registerModule(namespace, rootModule)
}
