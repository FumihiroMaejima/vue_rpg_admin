<template>
  <!-- <ProgressBar value="0" mode="indeterminate" /> -->
  <component :is="currentComponent" />
</template>

<script lang="ts">
import { defineComponent, ref, computed, Component, inject } from 'vue'
import AuthHeader from '@/components/_global/AuthHeader.vue'
import StaticHeader from '@/components/_global/StaticHeader.vue'
import ProgressBar from 'primevue/progressbar'
import Base from '@/plugins/auth/base'

export default defineComponent({
  name: 'GlobalHeader',
  components: {
    AuthHeader,
    StaticHeader
  },
  props: {},
  setup() {
    const isAuthenticated = ref<boolean>(true)
    const base = inject('authApp') as Base

    // computed
    const currentComponent = computed(
      (): Component => (isAuthenticated.value ? AuthHeader : StaticHeader)
    )

    // created
    const created = async() => {
      // await base.constructAction()
      console.log('created async action')
    }
    created()

    // created
    // setupでasyncをかけるとコンポーネントが表示されない為、非同期処理内のハンドリングで対応
    /* base.constructAction().then(() => {
      console.log('finish constructAction')
    }) */

    return {
      created,
      isAuthenticated,
      currentComponent
    }
  }
})
</script>
