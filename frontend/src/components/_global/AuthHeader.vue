<template>
  <Menubar :model="items">
    <template #start>
      <Button
        icon="pi pi-bookmark"
        class="p-button-rounded p-button-secondary"
        @click="openSideBar"
      />
    </template>
    <template #end>
      <!-- <div class="p-inputgroup">
        <InputText placeholder="Keyword" />
        <Button icon="pi pi-search" class="p-button-info" />
      </div> -->
    </template>
  </Menubar>
</template>

<script lang="ts">
import { defineComponent, getCurrentInstance, ref, SetupContext } from 'vue'
import Button from 'primevue/button'
// import InputText from 'primevue/inputtext'
import Menubar from 'primevue/menubar'

type Props = {}

export default defineComponent({
  name: 'AuthHeader',
  components: {
    Button,
    // InputText,
    Menubar
  },
  props: {},
  setup(props: Props, context: SetupContext) {
    let items = ref<string[]>([])

    // thisの取得
    const instance = getCurrentInstance()
    if (instance) {
      // consifgの取得
      items =
        instance.appContext.config.globalProperties.$AppConfig
          .headerMenuContents
    }

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