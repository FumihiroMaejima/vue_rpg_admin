<template>
  <div>
    <DataTable
      :value="roles"
      v-model:selection="selectedRoles"
      dataKey="id"
      :rowHover="true"
      class="p-datatable-sm p-datatable-gridlines editable-cells-table"
      :class="{ 'editable-cells-table': editable }"
      paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
      currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
      editMode="cell"
      :paginator="true"
      :rows="10"
    >
      <template #empty>
        No Character found.
      </template>
      <template #loading>
        Loading character data. Please wait.
      </template>
      <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>

      <Column
        :field="colOpt[0].field"
        :header="colOpt[0].header"
        :sortable="true"
        :style="colOpt[0].style"
      >
        <template #body="{data}">
          {{ data.id }}
        </template>
      </Column>

      <Column
        :field="colOpt[1].field"
        :header="colOpt[1].header"
        :sortable="true"
        :style="colOpt[1].style"
      >
        <template #body="{data}">
          <div class="app-table__text-field">
            {{ data.name }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="roles-table__form-input"
            type="text"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            @blur="
              catchTextBlurEvent(
                $event,
                colOpt[1].field,
                slotProps.data[colOpt[1].identifier]
              )
            "
            @update:modelValue="
              catchTextChange(
                $event,
                colOpt[1].field,
                slotProps.data[colOpt[1].identifier]
              )
            "
          />
        </template>
      </Column>

      <Column
        :field="colOpt[2].field"
        :header="colOpt[2].header"
        :sortable="true"
        :style="colOpt[2].style"
      >
        <template #body="{data}">
          <div class="app-table__text-field">
            {{ data.code }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="roles-table__form-input"
            type="text"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            @blur="
              catchTextBlurEvent(
                $event,
                colOpt[2].field,
                slotProps.data[colOpt[2].identifier]
              )
            "
            @update:modelValue="
              catchTextChange(
                $event,
                colOpt[2].field,
                slotProps.data[colOpt[2].identifier]
              )
            "
          />
        </template>
      </Column>

      <Column
        :field="colOpt[3].field"
        :header="colOpt[3].header"
        :sortable="true"
        :style="colOpt[3].style"
      >
        <template #body="{data}">
          <div class="app-table__text-field">
            {{ data.detail }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="roles-table__form-input"
            type="text"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            @blur="
              catchTextBlurEvent(
                $event,
                colOpt[3].field,
                slotProps.data[colOpt[3].identifier]
              )
            "
            @update:modelValue="
              catchTextChange(
                $event,
                colOpt[2].field,
                slotProps.data[colOpt[3].identifier]
              )
            "
          />
        </template>
      </Column>

      <Column
        :field="colOpt[4].field"
        :header="colOpt[4].header"
        :sortable="true"
        :style="colOpt[4].style"
      >
        <template #body="{data}">
          <span
            v-if="
              colOpt[4].type === 'select' &&
                colOpt[4].items &&
                colOpt[4].itemValue
            "
          >
            <span
              class="roles-table__chip"
              v-for="(item, index) of getMultiSelectLabel(
                data.permissions,
                colOpt[4].items
              )"
              :key="index"
            >
              {{ item }}
            </span>
          </span>
        </template>
        <template
          #editor="slotProps"
          v-if="editable && colOpt[4].type === 'select'"
        >
          <MultiSelect
            class="roles-table__form-dropdown"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            :options="colOpt[4].items"
            :optionLabel="colOpt[4].itemText"
            :optionValue="colOpt[4].itemValue"
            placeholder="select item"
            filter
            @change="
              catchSelectChange(
                $event,
                colOpt[4].field,
                slotProps.data[colOpt[4].identifier]
              )
            "
          />
        </template>
      </Column>
    </DataTable>
  </div>
</template>

<script lang="ts">
import {
  defineComponent,
  ref,
  Ref,
  PropType,
  reactive,
  computed,
  provide,
  watch,
  SetupContext,
  inject
} from 'vue'
import Column from 'primevue/column'
import DataTable from 'primevue/datatable'
import InputText from 'primevue/inputtext'
import MultiSelect from 'primevue/multiselect'
import Dropdown from 'primevue/dropdown'
import {
  // editableRole,
  tableSetting,
  RolesType,
  RolesTextKeys,
  RolesSelectKeys,
  RolesStateKey,
  RolesStateType
} from '@/services/roles'
import {
  editableRole,
  CharacterType,
  CharacterTextKeys,
  CharacterSelectKeys,
  CharactersStateKey
  // useState
} from '@/services/game/characters'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag, getMultiSelectLabel } from '@/util'
import { ToastType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

type Props = {
  selectRoles: RolesType[]
}

export default defineComponent({
  name: 'GameCharactersTable',
  components: {
    Column,
    DataTable,
    // Dropdown,
    MultiSelect,
    InputText
  },
  props: {
    selectRoles: {
      type: Array as PropType<RolesType[]>,
      required: false,
      default: () => {
        return []
      }
    }
  },
  setup(props: Props, context: SetupContext) {
    const toast = inject(ToastTypeKey) as ToastType
    const colOpt = reactive(tableSetting)
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const rolesService = inject(RolesStateKey) as RolesStateType
    const selectValue = ref<RolesType[]>([])

    // watch
    watch(
      () => rolesService.state.permissions,
      (newValue, old) => {
        if (colOpt[4].type === 'select') {
          colOpt[4].items = [...newValue]
        }
        /* ... */
      }
    )

    // computed
    const roles = computed((): RolesType[] => rolesService.state.roles)
    const editable = computed((): boolean =>
      authApp.checkAuthority(editableRole)
    )

    const selectedRoles = computed({
      get: (): RolesType[] => props.selectRoles,
      set: (value: RolesType[]) => {
        context.emit('update:selectRoles', value)
      }
    })

    // created
    /* const created = async () => {}
    created() */

    // methods
    /**
     * catch update text event
     * @param {string} value
     * @param {string} key
     * @param {number} id
     * @return {{id: number, key: string, value: string}}
     */
    const catchTextChange = (value: string, key: string, id: number) => {
      rolesService.updateStateTextValue(id, key as RolesTextKeys, value)
    }

    /**
     * catch update text event
     * @param {Event} event
     * @param {string} key
     * @param {number} id
     * @return {{id: number, key: string, value: boolean}}
     */
    const catchTextBlurEvent = async (
      event: Event,
      key: string,
      id: number
    ) => {
      inversionFlag(loadingFlag)
      const response = await rolesService.updateRolesDataRequest(
        id,
        authApp.getHeaderOptions()
      )

      if (response.status !== 304) {
        toast.add(rolesService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    /**
     * catch update select event
     * @param {{ originalEvent: Event; value: string[] | number[] }} event
     * @param {number} id
     * @param {string} key
     * @return {void}
     */
    const catchSelectChange = async (
      event: { originalEvent: Event; value: string[] | number[] },
      key: string,
      id: number
    ) => {
      rolesService.updateStateSelectValue(
        id,
        key as RolesSelectKeys,
        event.value as number[]
      )

      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      const response = await rolesService.updateRolesDataRequest(
        id,
        authApp.getHeaderOptions()
      )

      if (response.status !== 304) {
        toast.add(rolesService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    return {
      getMultiSelectLabel,
      roles,
      editable,
      catchTextBlurEvent,
      catchTextChange,
      catchSelectChange,
      colOpt,
      selectedRoles
    }
  }
})
</script>
<style lang="scss">
.roles-table {
  &__form-dropdown {
    width: 100%;
  }

  .roles-table__form-dropdown.p-dropdown {
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

  &__chip {
    display: inline-flex;
    margin: 0 2px;
    padding: 0 4px;
    flex-direction: row;
    background-color: #e5e5e5;
    cursor: default;
    height: 30px;
    font-size: 14px;
    color: #333333;
    font-family: 'Open Sans', sans-serif;
    white-space: nowrap;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
  }
}
</style>
