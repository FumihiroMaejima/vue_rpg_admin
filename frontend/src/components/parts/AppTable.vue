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
      <template #body="slotProps" v-if="col.type === 'select' && col.items && col.itemValue">
        <span>{{
          col.items.find(
            (item) =>
              item[col.itemValue] === slotProps.data[slotProps.column.props.field]
          ).text
        }}</span>
      </template>
      <template #editor="slotProps" v-if="col.editable">
        <template v-if="col.type === 'text'">
          <InputText
            type="text"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            @blur="
              catchTextBlurEvent(
                $event,
                col.field,
                slotProps.data[col.identifier]
              )
            "
            @update:modelValue="
              catchTextChange($event, col.field, slotProps.data[col.identifier])
            "
          />
        </template>
        <template v-else>
          <Dropdown
            :modelValue="slotProps.data[slotProps.column.props.field]"
            :options="col.items"
            :optionLabel="col.itemText"
            :optionValue="col.itemValue"
            placeholder="select item"
            filter
            @change="
              catchSelectChange(
                $event,
                col.field,
                slotProps.data[col.identifier]
              )
            "
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
import {
  defineComponent,
  PropType,
  SetupContext /* , ref, reactive */
} from 'vue'
import Column from 'primevue/column'
// import ColumnGroup from 'primevue/columngroup'
import DataTable from 'primevue/datatable'
import InputText from 'primevue/inputtext'
import MultiSelect from 'primevue/multiselect'
import Dropdown from 'primevue/dropdown'
// import Dropdown from 'primevue/dropdown'
import { TableColumnSetting } from '@/types/config/data'
import { SelectBoxType } from '@/types/components/index'

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
     * catch update text event
     * @param {string} value
     * @param {string} key
     * @param {number} id
     * @return {{id: number, key: string, value: string}}
     */
    const catchTextChange = (value: string, key: string, id: number) => {
      context.emit('update-text', { id, key, value })
    }

    /**
     * catch update text event
     * @param {Event} event
     * @param {string} key
     * @param {number} id
     * @return {{id: number, key: string, value: boolean}}
     */
    const catchTextBlurEvent = (event: Event, key: string, id: number) => {
      context.emit('blur-text', { id, key, value: event.returnValue })
    }

    /**
     * catch update select event
     * @param {{ originalEvent: Event; value: string | number }} event
     * @param {number} id
     * @param {string} key
     * @return {{id: number, key: string, value: string | null}}
     */
    const catchSelectChange = (
      event: { originalEvent: Event; value: string | number },
      key: string,
      id: number
    ) => {
      context.emit('update-select', { id, key, value: event.value })
    }

    return {
      catchTextBlurEvent,
      catchTextChange,
      catchSelectChange
    }
  }
})
</script>
