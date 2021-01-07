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
      <div class="p-col-12">
        <DataTable :value="items.data">
          <Column field="vin" header="Vin"></Column>
          <Column field="year" header="Year"></Column>
          <Column field="brand" header="Brand"></Column>
          <Column field="color" header="Color"></Column>
        </DataTable>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, reactive } from 'vue'
import Column from 'primevue/column'
// import ColumnGroup from 'primevue/columngroup'
import DataTable from 'primevue/datatable'

import { tableData } from '@/config/resource'

export default defineComponent({
  name: 'Home',
  components: {
    Column,
    // ColumnGroup,
    DataTable
  },
  setup() {
    const display = ref<boolean>(true)
    const items = reactive(tableData)


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
      catchAppInputEvent
    }
  }
})
</script>
