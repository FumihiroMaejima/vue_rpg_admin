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
        <DataTable
          :value="items.data"
          class="p-datatable-sm p-datatable-gridlines"
        >
          <template #header>
            Header
          </template>
          <Column
            v-for="col of headers"
            :field="col.field"
            :header="col.header"
            :key="col.field"
          ></Column>
          <template #footer>
            Footer
          </template>
        </DataTable>
      </div>
      <div class="p-col-12 p-md-1"></div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, reactive } from 'vue'
import Column from 'primevue/column'
// import ColumnGroup from 'primevue/columngroup'
import DataTable from 'primevue/datatable'

import { tableData, tableKeys } from '@/config/resource'

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
    const headers = reactive(tableKeys)

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
      headers,
      catchAppInputEvent
    }
  }
})
</script>
