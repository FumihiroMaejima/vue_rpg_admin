<template>
  <dev>
    <global-header @click-icon="onSideBarInput" />
    <app-side-bar :value="openSideBar" @close="onSideBarInput" />
    <section class="p-mx-2 p-mb-2">
      <router-view />
    </section>
    <global-footer />
  </dev>
</template>

<script lang="ts">
import { defineComponent, ref, computed, SetupContext } from 'vue'
import GlobalHeader from '@/components/_global/GlobalHeader.vue'
import GlobalFooter from '@/components/_global/GlobalFooter.vue'
import AppSideBar from '@/components/parts/AppSideBar.vue'

export default defineComponent({
  components: {
    AppSideBar,
    GlobalHeader,
    GlobalFooter
  },
  setup() {
    const openSideBar = ref<boolean>(false)

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
