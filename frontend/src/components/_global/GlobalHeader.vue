<template>
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

type Props = {}

export default defineComponent({
  name: 'GlobalHeader',
  components: {
    AuthHeader,
    StaticHeader
  },
  props: {},
  setup(props: Props, context: SetupContext) {
    const isAuthenticated = ref<boolean>(false)

    // computed
    const currentComponent = computed(
      (): Component => (isAuthenticated.value ? AuthHeader : StaticHeader)
    )

    // instanceの取得
    /* const instance = getCurrentInstance()
    if (instance) {

    } */

    /**
     * catch click event
     * @return {void}
     */
    const openSideBar = () => {
      context.emit('click-icon', true)
    }

    return {
      isAuthenticated,
      currentComponent,
      openSideBar
    }
  }
})
</script>
