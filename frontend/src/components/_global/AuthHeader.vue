<template>
  <Menubar :model="items">
    <template #start>
      <Button
        icon="pi pi-home"
        class="p-button-rounded p-button-secondary"
        @click="openSideBar"
      />
    </template>
    <template #end>
      <Button
        icon="pi pi-refresh"
        class="p-button-rounded p-button-secondary"
        label="Sign Out"
        @click="logoutFunction"
      />
      <!-- <div class="p-inputgroup">
        <InputText placeholder="Keyword" />
        <Button icon="pi pi-search" class="p-button-info" />
      </div> -->
    </template>
  </Menubar>
</template>

<script lang="ts">
import { defineComponent, getCurrentInstance, ref, SetupContext } from 'vue'
import Button from 'primevue/button'
// import InputText from 'primevue/inputtext'
import Menubar from 'primevue/menubar'
import AuthApp from '@/plugins/auth/authApp'

type Props = {
  authApp: AuthApp
}

export default defineComponent({
  name: 'AuthHeader',
  components: {
    Button,
    // InputText,
    Menubar
  },
  props: {
    authApp: {
      type: AuthApp,
      required: true
    }
  },
  setup(props: Props, context: SetupContext) {
    let items = ref<string[]>([])

    // instanceの取得
    const instance = getCurrentInstance()
    if (instance) {
      // consifgの取得
      items =
        instance.appContext.config.globalProperties.$AppConfig
          .headerMenuContents
    }

    // methods
    /**
     * catch click event
     * @return {void}
     */
    const openSideBar = () => {
      context.emit('click-icon', true)
    }

    /**
     * logout handler
     * @return {void}
     */
    const logoutFunction = async () => {
      await props.authApp.logout()
    }

    return {
      items,
      openSideBar,
      logoutFunction
    }
  }
})
</script>
