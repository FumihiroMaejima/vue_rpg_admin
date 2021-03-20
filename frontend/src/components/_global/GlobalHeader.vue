<template>
  <component :is="currentComponent" :authApp="authApp" />
</template>

<script lang="ts">
import { defineComponent, computed, Component, inject } from 'vue'
import AuthHeader from '@/components/_global/AuthHeader.vue'
import StaticHeader from '@/components/_global/StaticHeader.vue'
import AuthApp from '@/plugins/auth/authApp'
import { AuthAppKey } from '@/keys'

export default defineComponent({
  name: 'GlobalHeader',
  components: {
    AuthHeader,
    StaticHeader
  },
  props: {},
  setup() {
    const authApp = inject(AuthAppKey) as AuthApp

    // computed
    const currentComponent = computed(
      (): Component => (authApp.getAuthId() ? AuthHeader : StaticHeader)
    )

    // created
    /* const created = async () => {}
    created() */

    return {
      // created,
      authApp,
      currentComponent
    }
  }
})
</script>
