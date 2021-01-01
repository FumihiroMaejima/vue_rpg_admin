<template>
  <div
    class="grid rounded"
    :class="
      `md:grid-cols-${mdCols} sm:grid-cols-${smCols} gap-${gap} ${option}`
    "
  >
    <slot />
  </div>
</template>

<script lang="ts">
import { defineComponent /* , computed */ } from 'vue'

type Props = {
  mdCols: number
  smCols: number
  gap: number
  option: string
}

export default defineComponent({
  name: 'GridCols',
  props: {
    mdCols: {
      type: Number,
      default: 3
    },
    smCols: {
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
  setup(/* props: Props */) {
    // computed
    // const mdColsClass = computed(() => `md:grid-cols-${props.mdCols}`)
    // const smColsClass = computed(() => `sm:grid-cols-${props.smCols}`)
    return {
      // mdColsClass,
      // smColsClass
    }
  }
})
</script>
