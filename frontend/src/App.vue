<template>
  <div>
    <Toast position="top-right" />
    <liner-loading :open="openLinerLoading" />
    <circle-loading :open="openCircleLoading" />
    <global-header @click-icon="onSideBarInput" />
    <app-side-bar v-model:value="isOpenSideBar" @close="onSideBarInput" />
    <section class="p-mx-2 p-mb-2">
      <router-view />
    </section>
    <global-footer />
  </div>
</template>

<script lang="ts">
import {
  defineComponent,
  ref,
  computed,
  SetupContext,
  provide,
  inject,
  Ref
} from 'vue'
import GlobalHeader from '@/components/_global/GlobalHeader.vue'
import GlobalFooter from '@/components/_global/GlobalFooter.vue'
import AppSideBar from '@/components/parts/AppSideBar.vue'
import CircleLoading from '@/components/parts/CircleLoading.vue'
import LinerLoading from '@/components/parts/LinerLoading.vue'
import Toast from 'primevue/toast'
import { useToast } from 'primevue/usetoast'
import { ToastTypeKey, CircleLoadingKey, LinerLoadingKey } from '@/keys'

export default defineComponent({
  components: {
    AppSideBar,
    GlobalHeader,
    GlobalFooter,
    CircleLoading,
    LinerLoading,
    Toast
  },
  setup() {
    const openSideBar = ref<boolean>(false)
    const openCircleLoading = ref<boolean>(false)
    const openLinerLoading = inject(LinerLoadingKey) as Ref<boolean>
    provide(CircleLoadingKey, openCircleLoading)
    const toast = useToast()
    provide(ToastTypeKey, toast)

    // computed
    const isOpenSideBar = computed({
      get: (): boolean => openSideBar.value,
      set: (value: boolean) => {
        openSideBar.value = value
      }
    })

    /**
     * catch sidebar open event
     * @return {void}
     */
    const onSideBarInput = (event: boolean) => {
      openSideBar.value = event
    }

    return {
      openLinerLoading,
      openCircleLoading,
      toast,
      openSideBar,
      onSideBarInput,
      isOpenSideBar
    }
  }
})
</script>
<style lang="scss">
body {
  margin: initial;
}
</style>
