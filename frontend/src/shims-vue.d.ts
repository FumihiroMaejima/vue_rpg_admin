declare module '*.vue' {
  // import type { DefineComponent } from 'vue' // eslint error.
  import { DefineComponent } from 'vue'
  const component: DefineComponent<{}, {}, any>
  export default component
}
