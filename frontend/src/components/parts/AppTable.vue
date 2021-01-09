<template>
  <DataTable
    :value="items"
    class="p-datatable-sm p-datatable-gridlines"
    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
    currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
    :paginator="true"
    :rows="10"
  >
    <template #header>
      Header
    </template>
    <Column
      v-for="col of headerOptions"
      :field="col.field"
      :header="col.header"
      :key="col.field"
    ></Column>
    <template #footer>
      Footer
    </template>
  </DataTable>
</template>

<script lang="ts">
import { defineComponent /* , ref, reactive */ } from 'vue'
import Column from 'primevue/column'
// import ColumnGroup from 'primevue/columngroup'
import DataTable from 'primevue/datatable'

type Props = {
  items: string
  headerOptions: string
}

export default defineComponent({
  name: 'AppTable',
  components: {
    Column,
    // ColumnGroup,
    DataTable
  },
  props: {
    items: {
      type: Array,
      default: () => {
        return []
      }
    },
    headerOptions: {
      type: Array,
      default: () => {
        return []
      }
    }
  },
  setup() {
    // methods
    /**
     * catch app-input event
     * @return {void}
     */
    const catchAppInputEvent = (event: any) => {
      console.log('catchAppInputEvent: ' + JSON.stringify(event, null, 2))
    }
    return {
      catchAppInputEvent
    }
  }
})
</script>
