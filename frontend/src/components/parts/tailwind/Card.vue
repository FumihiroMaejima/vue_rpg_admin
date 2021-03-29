<template>
  <div
    class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl"
  >
    <div class="md:flex">
      <div class="md:flex-shrink-0">
        <img
          class="h-48 w-full object-cover md:w-48"
          src="/img/test.jpg"
          alt="alter image string."
        />
      </div>
      <div class="p-8">
        <div
          class="uppercase tracking-wide text-sm text-indigo-500 font-semibold"
        >
          Card Header
        </div>
        <a
          href="#"
          class="block mt-1 text-lg leading-tight font-medium text-black hover:underline"
          >Text Header</a
        >
        <p class="mt-2 text-gray-500">
          This is Card Text.This is Card Text.
        </p>
      </div>
    </div>
  </div>
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
  name: 'Card',
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
      default: 'font-sans'
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
