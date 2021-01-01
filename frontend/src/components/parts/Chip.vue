<template>
  <div
    class="rounded-full flex items-center justify-center"
    :class="
      `bg-${color}-500 hover:bg-${color}-700 ${font} ${textColor} ${option}` +
        { 'h-24 w-24': isCircle, 'py-3 px-6': !isCircle }
    "
  >
    {{ text }}
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

type Props = {
  text: string
  color: string
  textColor: string
  font: string
  isCircle: boolean
  option: string
}

export default defineComponent({
  name: 'Chip',
  props: {
    text: {
      type: String,
      default: 'chip text'
    },
    color: {
      type: String,
      default: 'green'
    },
    textColor: {
      type: String,
      default: 'text-white'
    },
    font: {
      type: String,
      default: 'font-semibold'
    },
    isCircle: {
      type: Boolean,
      default: false
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
