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
      <template #body="slotProps" v-if="col.type === 'select' && col.items">
        <span>{{ col.items.find(item => item[col.field] === slotProps.data[slotProps.column.props.field]).text }}</span>
      </template>
      <template #editor="slotProps" v-if="editable">
        <template v-if="col.type === 'text'">
          <InputText v-model="slotProps.data[slotProps.column.props.field]" />
        </template>
        <template v-else>
          <Dropdown
            v-model="slotProps.data[slotProps.column.props.field]"
            :options="col.items"
            :optionLabel="col.itemText"
            :optionValue="col.itemValue"
            placeholder="select item"
            filter
            @change="catchSelectChange($event, slotProps.data[col.identifier])"
          />
        </template>
      </template>
    </Column>
    <template #footer v-if="addFooter">
      Footer
    </template>
  </DataTable>
</template>

<script lang="ts">
import { defineComponent, PropType, SetupContext /* , ref, reactive */ } from 'vue'
import Column from 'primevue/column'
// import ColumnGroup from 'primevue/columngroup'
import DataTable from 'primevue/datatable'
import InputText from 'primevue/inputtext'
import MultiSelect from 'primevue/multiselect'
import Dropdown from 'primevue/dropdown'
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
    Dropdown,
    // MultiSelect,
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
  setup(prpops: Props, context: SetupContext) {
    // methods
    /**
     * catch app-input event
     * @return {void}
     */
    const catchAppInputEvent = (event: any) => {
      console.log('catchAppInputEvent: ' + JSON.stringify(event, null, 2))
    }

    const catchSelectChange = (event: { originalEvent: Event, value: string | number }, id: number) => {
      console.log('changeEvent id: ' + JSON.stringify(id, null, 2))
      context.emit('update-select', {id, value: event.value})
    }
    return {
      catchSelectChange,
      catchAppInputEvent
    }
  }
})
</script>
