<template>
  <button
    class="rounded-lg shadow-md py-2 px-4"
    :class="
      `bg-${color}-500 hover:bg-${color}-700 border-${color}-600 active:bg-${color}-300 ${font} ${textColor} ${option}`
    "
    @click="onClick"
  >
    {{ text }}
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

type Props = {
  text: string
  color: string
  textColor: string
  font: string
  option: string
}

export default defineComponent({
  name: 'AppButton',
  props: {
    text: {
      type: String,
      default: 'button text'
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
    option: {
      type: String,
      default: ''
    }
  },
  setup() {
    /**
     * catch click event
     * @return {void}
     */
    const onClick = (event: any) => {
      console.log('click: ' + JSON.stringify(event, null, 2))
    }
    return {
      onClick
    }
  }
})
</script>
