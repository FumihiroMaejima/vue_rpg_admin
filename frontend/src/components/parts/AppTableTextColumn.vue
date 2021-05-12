<template>
  <Column
    :field="options.field"
    :header="options.header"
    :sortable="true"
    :style="options.style"
  >
    <template #body="{data}">
      <div class="app-table-text-column__text-field">
        {{ data[options.field] }}
      </div>
    </template>
    <template #editor="slotProps" v-if="editable">
      <InputText
        class="app-table-text-column__form-input"
        type="text"
        :modelValue="slotProps.data[slotProps.column.props.field]"
        @blur="
          catchTextBlurEvent(
            $event,
            options.field,
            slotProps.data[options.identifier]
          )
        "
        @update:modelValue="
          catchTextChange(
            $event,
            options.field,
            slotProps.data[options.identifier]
          )
        "
      />
    </template>
  </Column>
</template>

<script lang="ts">
import {
  defineComponent,
  PropType,
  SetupContext /* , ref, reactive */
} from 'vue'
import Column from 'primevue/column'
import InputText from 'primevue/inputtext'
import { TableColumnSetting } from '@/types/config/data'

type Props = {
  options: TableColumnSetting
  editable: boolean
}

export default defineComponent({
  name: 'AppTableTextColumn',
  components: {
    Column,
    InputText
  },
  props: {
    options: {
      type: Object as PropType<TableColumnSetting>,
      default: () => {
        return {}
      }
    },
    editable: {
      type: Boolean,
      default: false
    }
  },
  setup(prpops: Props, context: SetupContext) {
    // methods

    /**
     * catch blur text field event
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

    return {
      catchTextBlurEvent,
      catchTextChange
    }
  }
})
</script>
<style lang="scss">
.app-table-text-column {
  &__form-dropdown {
    width: 100%;
  }

  .app-table-text-column__form-dropdown.p-dropdown {
    padding: 0 0 0 0 !important;
  }

  &__form-input {
    width: 100%;
    input {
      width: 100%;
    }
  }

  &__text-field {
    word-break: break-all;
  }
}
</style>
