<template>
  <Sidebar class="app-side-bar" v-model:visible="openSideBar" position="left">
    <h1>sidebar content</h1>
    <Menu :model="items" @click="hideMenu" />
  </Sidebar>
</template>

<script lang="ts">
import {
  defineComponent,
  getCurrentInstance,
  ref,
  computed,
  SetupContext
} from 'vue'
import Menu from 'primevue/menu'
import Sidebar from 'primevue/sidebar'

type Props = {
  value: boolean
}

export default defineComponent({
  name: 'AppSideBar',
  components: {
    Menu,
    Sidebar
  },
  props: {
    value: {
      type: Boolean,
      default: true
    }
  },
  setup(props: Props, context: SetupContext) {
    let items = ref<string[]>([])

    // computed
    const openSideBar = computed({
      get: (): boolean => props.value,
      set: (value: boolean) => {
        context.emit('close', value)
      }
    })

    // instanceの取得
    const instance = getCurrentInstance()
    if (instance) {
      // consifgの取得
      items =
        instance.appContext.config.globalProperties.$AppConfig.sideBarContents
    }

    const hideMenu = (event: Event) => {
      context.emit('close', event.returnValue)
    }

    return {
      openSideBar,
      hideMenu,
      items
    }
  }
})
</script>
<style lang="scss" scoped>
.app-side-bar {
  overflow: scroll;
}
</style>
