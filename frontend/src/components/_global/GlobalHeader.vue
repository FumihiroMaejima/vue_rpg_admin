<template>
  <!-- <ProgressBar value="0" mode="indeterminate" /> -->
  <component :is="currentComponent" />
</template>

<script lang="ts">
import {
  defineComponent,
  getCurrentInstance,
  ref,
  SetupContext,
  computed,
  Component,
  inject
} from 'vue'
import AuthHeader from '@/components/_global/AuthHeader.vue'
import StaticHeader from '@/components/_global/StaticHeader.vue'
import ProgressBar from 'primevue/progressbar'
import Base from '@/plugins/auth/base'

type Props = {}

export default defineComponent({
  name: 'GlobalHeader',
  components: {
    AuthHeader,
    StaticHeader
  },
  props: {},
  async setup(props: Props, context: SetupContext) {
    const isAuthenticated = ref<boolean>(false)

    // computed
    const currentComponent = computed(
      (): Component => (isAuthenticated.value ? AuthHeader : StaticHeader)
    )

    // instanceの取得
    /* const instance = getCurrentInstance()
    if (instance) {
      console.log('g-h check: ' + JSON.stringify(null, null, 2))
    } */
    const base = inject('authApp') as Base
    await base.constructAction()
    console.log('g-h getStore: ' + JSON.stringify(base.getAuthId(), null, 2))

    return {
      isAuthenticated,
      currentComponent
    }
  }
})
</script>
