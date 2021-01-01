<template>
  <dev>
    <global-header />
    <router-view />
    <global-footer />
  </dev>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import GlobalHeader from '@/components/_global/GlobalHeader.vue'
import GlobalFooter from '@/components/_global/GlobalFooter.vue'

export default defineComponent({
  components: {
    GlobalHeader,
    GlobalFooter
  },
  setup() {
    return {}
  }
})
</script>
