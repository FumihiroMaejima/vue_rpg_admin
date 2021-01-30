<template>
  <Menubar :model="items">
    <template #start>
      <Button
        icon="pi pi-bookmark"
        class="p-button-rounded p-button-secondary"
      />
    </template>
    <template #end> </template>
  </Menubar>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import Button from 'primevue/button'
import Menubar from 'primevue/menubar'

export default defineComponent({
  name: 'StaticHeader',
  components: {
    Button,
    Menubar
  },
  props: {},
  setup() {
    const items = ref<string[]>([])

    return {
      items
    }
  }
})
</script>
