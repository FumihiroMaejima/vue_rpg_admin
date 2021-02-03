<template>
  <!-- <ProgressBar value="0" mode="indeterminate" /> -->
  <component :is="currentComponent" />
</template>

<script lang="ts">
import { defineComponent, computed, Component, inject } from 'vue'
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
    const base = inject('authApp') as Base

    // computed
    const currentComponent = computed(
      (): Component => (base.getAuthId() ? AuthHeader : StaticHeader)
    )

    // created
    const created = async () => {
      console.log('created async action')
    }
    created()

    return {
      created,
      currentComponent
    }
  }
})
</script>
