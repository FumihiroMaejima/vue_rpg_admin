<template>
  <nav
    class="flex items-center justify-between flex-wrap bg-gray-600 p-6 global-header"
  >
    <div class="flex items-center flex-shrink-0 text-white mr-6">
      <span class="font-semibold text-xl tracking-tight">{{ header }}</span>
    </div>
    <div class="block lg:hidden">
      <button
        class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white"
        @click="isOpen = !isOpen"
      >
        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20">
          <title>Menu</title>
          <path
            v-show="!isOpen"
            d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"
          />
          <path
            v-show="isOpen"
            d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"
          />
        </svg>
      </button>
    </div>
    <div
      :class="isOpen ? 'block' : 'hidden'"
      class="w-full block flex-grow lg:flex lg:items-center lg:w-auto"
    >
      <div class="text-sm lg:flex-grow">
        <a
          v-for="(value, key) in contents"
          v-bind:key="key"
          href="#responsive-header"
          class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white"
          :class="{ 'mr-4': key !== contents.length - 1 }"
        >
          {{ value }}
        </a>
      </div>
    </div>
  </nav>
</template>

<script lang="ts">
import { defineComponent, getCurrentInstance, ref } from 'vue'

export default defineComponent({
  name: 'GlobalHeader',
  setup() {
    let header = ref<string>('header')
    let contents = ref<string[]>([])
    const isOpen = ref<boolean>(false)

    // thisの取得
    const instance = getCurrentInstance()
    if (instance) {
      // consifgの取得
      header = instance.appContext.config.globalProperties.$AppConfig.headerName
      contents =
        instance.appContext.config.globalProperties.$AppConfig.headerContents
    }

    return {
      header,
      contents,
      isOpen
    }
  }
})
</script>
<style lang="scss" scoped>
.global-header {
  /* button:focus {
    outline: none !important; // for Google Chrome
  } */
}
</style>
