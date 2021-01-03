<template>
  <i class="pi" :class="`pi-${name}`" :style="`fontSize: ${size}rem`"> </i>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

type Props = {
  name: string
  size: number
}

export default defineComponent({
  name: 'AppIcon',
  props: {
    name: {
      type: String,
      default: 'github'
    },
    size: {
      type: Number,
      default: 1
    }
  },
  setup() {
    return {}
  }
})
</script>
