<template>
  <Menubar :model="items">
    <template #start>
      <Button
        icon="pi pi-bookmark"
        class="p-button-rounded p-button-secondary"
        @click="openSideBar"
      />
    </template>
    <template #end> </template>
  </Menubar>
</template>

<script lang="ts">
import { defineComponent, ref, SetupContext } from 'vue'
import Button from 'primevue/button'
import Menubar from 'primevue/menubar'

type Props = {}

export default defineComponent({
  name: 'StaticHeader',
  components: {
    Button,
    Menubar
  },
  props: {},
  setup(props: Props, context: SetupContext) {
    const items = ref<string[]>([])

    /**
     * catch click event
     * @return {void}
     */
    const openSideBar = () => {
      context.emit('click-icon', true)
    }

    return {
      items,
      openSideBar
    }
  }
})
</script>
