<template>
  <!-- <ProgressBar value="0" mode="indeterminate" /> -->
  <component :is="currentComponent" :authApp="authApp" />
</template>

<script lang="ts">
import { defineComponent, computed, Component, inject } from 'vue'
import AuthHeader from '@/components/_global/AuthHeader.vue'
import StaticHeader from '@/components/_global/StaticHeader.vue'
import ProgressBar from 'primevue/progressbar'
import AuthApp from '@/plugins/auth/authApp'

export default defineComponent({
  name: 'GlobalHeader',
  components: {
    AuthHeader,
    StaticHeader
  },
  props: {},
  setup() {
    const authApp = inject('authApp') as AuthApp

    // computed
    const currentComponent = computed(
      (): Component => (authApp.getAuthId() ? AuthHeader : StaticHeader)
    )

    // created
    const created = async () => {
      console.log('created async action')
    }
    created()

    return {
      created,
      authApp,
      currentComponent
    }
  }
})
</script>
