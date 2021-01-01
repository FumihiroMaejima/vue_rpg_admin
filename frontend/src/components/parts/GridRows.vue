<template>
  <div
    class="grid rounded grid-flow-col"
    :class="
      `md:grid-rows-${mdRows} sm:grid-rows-${smRows} gap-${gap} ${option}`
    "
  >
    <slot />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

type Props = {
  mdRows: number
  smRows: number
  gap: number
  option: string
}

export default defineComponent({
  name: 'GridRows',
  props: {
    mdRows: {
      type: Number,
      default: 3
    },
    smRows: {
      type: Number,
      default: 1
    },
    gap: {
      type: Number,
      default: 4
    },
    option: {
      type: String,
      default: ''
    }
  },
  setup() {
    return {}
  }
})
</script>
