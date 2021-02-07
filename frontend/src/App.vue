<template>
  <dev>
    <liner-loading :open="openLinerLoading" />
    <circle-loading :open="openCircleLoading" />
    <global-header @click-icon="onSideBarInput" />
    <app-side-bar :value="openSideBar" @close="onSideBarInput" />
    <section class="p-mx-2 p-mb-2">
      <router-view />
    </section>
    <global-footer />
  </dev>
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

export default defineComponent({
  components: {
    AppSideBar,
    GlobalHeader,
    GlobalFooter,
    CircleLoading,
    LinerLoading
  },
  setup() {
    const openSideBar = ref<boolean>(false)
    const openCircleLoading = ref<boolean>(false)
    const openLinerLoading = inject('linerLoading') as Ref<boolean>
    provide('circleLoading', openCircleLoading)

    // computed
    // v-modelのsetterが通らない
    const isOpenSideBar = computed({
      get: () => openSideBar,
      set: (value) => {
        console.log('setter isOpenSideBar: ' + JSON.stringify(value, null, 2))
        // openSideBar.value = value
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
