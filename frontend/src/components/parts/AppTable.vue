<template>
  <DataTable
    :value="items"
    class="p-datatable-sm p-datatable-gridlines editable-cells-table"
    :class="{ 'editable-cells-table': editable }"
    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
    currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
    editMode="cell"
    :paginator="true"
    :rows="10"
  >
    <template #header v-if="addHeader">
      Header
    </template>
    <Column
      v-for="(col, index) of columnOptions"
      :key="index"
      :field="col.field"
      :header="col.header"
      :sortable="sortable"
    >
      <template #editor="slotProps" v-if="editable">
        <template v-if="col.type === 'text'">
          <InputText v-model="slotProps.data[slotProps.column.props.field]" />
        </template>
        <template v-else>
          <MultiSelect
            v-model="slotProps.data[slotProps.column.props.field]"
            :options="col.items"
            :optionLabel="col.itemText"
            :optionValue="col.itemValue"
            placeholder="select item"
          >
          </MultiSelect>
        </template>
      </template>
    </Column>
    <template #footer v-if="addFooter">
      Footer
    </template>
  </DataTable>
</template>

<script lang="ts">
import { defineComponent, PropType /* , ref, reactive */ } from 'vue'
import Column from 'primevue/column'
// import ColumnGroup from 'primevue/columngroup'
import DataTable from 'primevue/datatable'
import InputText from 'primevue/inputtext'
import MultiSelect from 'primevue/multiselect'
// import Dropdown from 'primevue/dropdown'
import { TableColumnSetting } from '@/types/config/data'

type Props = {
  items: any[]
  columnOptions: TableColumnSetting[]
  sortable: boolean
  editable: boolean
  addHeader: boolean
  addFooter: boolean
}

export default defineComponent({
  name: 'AppTable',
  components: {
    Column,
    // ColumnGroup,
    DataTable,
    MultiSelect,
    InputText
  },
  props: {
    items: {
      type: Array,
      default: () => {
        return []
      }
    },
    columnOptions: {
      type: Array as PropType<TableColumnSetting[]>,
      default: () => {
        return []
      }
    },
    sortable: {
      type: Boolean,
      default: true
    },
    editable: {
      type: Boolean,
      default: false
    },
    addHeader: {
      type: Boolean,
      default: false
    },
    addFooter: {
      type: Boolean,
      default: false
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

    const changeEvent = (event: Event) => {
      console.log('changeEvent: ' + JSON.stringify(event, null, 2))
    }
    return {
      changeEvent,
      catchAppInputEvent
    }
  }
})
</script>
