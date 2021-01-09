<template>
  <div class="cp-fluid p-mb-6">
    <h1 class="italic my-2">ゲーム</h1>
    <i class="pi pi-check"></i>
    <i class="pi pi-github"></i>
    <div class="p-grid">
      <div class="p-col-12 p-md-6 p-lg-3"><i class="pi pi-check"></i></div>
      <div class="p-col-12 p-md-6 p-lg-3"><i class="pi pi-github"></i></div>
      <div class="p-col-12 p-md-6 p-lg-3"><i class="pi pi-check"></i></div>
      <div class="p-col-12 p-md-6 p-lg-3"><i class="pi pi-github"></i></div>
    </div>

    <div class="p-grid ">
      <!-- <div class="p-col-12 p-md-4"></div>
      <div class="p-col-12 p-md-4"></div>
      <div class="p-col-12 p-md-4"></div> -->
      <div class="p-col-12 p-md-1"></div>
      <div class="p-col-12 p-md-10">
        <app-table :items="items.data" :headerOptions="headerOptions" />
      </div>
      <div class="p-col-12 p-md-1"></div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, reactive } from 'vue'
import AppTable from '@/components/parts/AppTable.vue'
import { tableData, tableKeys } from '@/config/resource'

export default defineComponent({
  name: 'Home',
  components: {
    AppTable
  },
  setup() {
    const display = ref<boolean>(true)
    const items = reactive(tableData)
    const headerOptions = reactive(tableKeys)

    // methods
    /**
     * catch app-input event
     * @return {void}
     */
    const catchAppInputEvent = (event: any) => {
      console.log('catchAppInputEvent: ' + JSON.stringify(event, null, 2))
    }
    return {
      display,
      items,
      headerOptions,
      catchAppInputEvent
    }
  }
})
</script>
