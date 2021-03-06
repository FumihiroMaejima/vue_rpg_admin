<template>
  <Menubar :model="[]">
    <template #start>
      <Button
        icon="pi pi-bars"
        class="p-button-rounded p-button-secondary"
        @click="openSideBar"
      />
    </template>
    <template #end>
      <Button
        class="p-button-sm p-button-text p-button-secondary"
        :disabled="true"
        :label="`Hello, ${name}`"
      />
      <Button
        class="p-button-text p-button-secondary"
        :icon="iconValue"
        :label="buttonText"
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
import {
  defineComponent,
  getCurrentInstance,
  ref,
  SetupContext,
  computed,
  Ref,
  inject
} from 'vue'
import Button from 'primevue/button'
// import InputText from 'primevue/inputtext'
import Menubar from 'primevue/menubar'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { ToastType } from '@/types'
import { ToastTypeKey, CircleLoadingKey } from '@/keys'

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
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const toast = inject(ToastTypeKey) as ToastType

    // instanceの取得
    const instance = getCurrentInstance()
    if (instance) {
      // consifgの取得
      items =
        instance.appContext.config.globalProperties.$AppConfig
          .headerMenuContents
    }

    // computed
    const iconValue = computed((): string =>
      loadingFlag.value ? 'pi pi-spin pi-spinner' : 'pi pi-refresh'
    )

    const buttonText = computed((): string =>
      loadingFlag.value ? 'Now Sign Out' : 'Sign Out'
    )

    const name = computed(
      (): string | null =>
        `${props.authApp.getAuthAuthority()} ${props.authApp.getAuthName()}`
    )

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
      inversionFlag(loadingFlag)
      const response = await props.authApp.logout()
      inversionFlag(loadingFlag)
      toast.add({
        severity: response ? 'success' : 'error',
        summary: `Logout ${response ? 'Success' : 'Failed'}`,
        detail: `Logout Request is ${
          response ? 'Success' : 'Failed & Automatically logout'
        }.`,
        life: 3000
      })
    }

    return {
      items,
      loadingFlag,
      iconValue,
      buttonText,
      name,
      openSideBar,
      logoutFunction
    }
  }
})
</script>
