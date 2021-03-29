<template>
  <input
    class="rounded shadow-inner focus:outline-none focus:ring-2 focus:border-transparent py-1 px-2"
    :class="`focus:ring-${color}-600 ${font} ${option}`"
    :type="type"
    :placeholder="placeholder"
    :disabled="disabled"
    v-model="inputValue"
  />
</template>

<script lang="ts">
import { defineComponent, computed, SetupContext } from 'vue'

type Props = {
  value: string | number | boolean | object
  color: string
  type: string
  disabled: boolean
  font: string
  option: string
}

export default defineComponent({
  name: 'AppInput',
  props: {
    value: {
      type: [String, Number, Boolean, Object],
      default: ''
    },
    color: {
      type: String,
      default: 'blue'
    },
    type: {
      type: String,
      default: 'text'
    },
    placeholder: {
      type: String,
      default: ''
    },
    disabled: {
      type: Boolean,
      default: false
    },
    font: {
      type: String,
      default: 'font-sans' // font-mono, font-semibold, font-serif, font-sans
    },
    option: {
      type: String,
      default: ''
    }
  },
  setup(props: Props, context: SetupContext) {
    // computed
    const inputValue = computed({
      get: () => props.value,
      set: (val) => {
        context.emit('app-input', val)
      }
    })

    return {
      inputValue
    }
  }
})
</script>
