<template>
  <div>
    <DataTable
      :value="members"
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
          No Roles found.
      </template>
      <template #loading>
          Loading roles data. Please wait.
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
            {{ data.email }}
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
          <span
            v-if="
              colOpt[3].type === 'select' &&
                colOpt[3].items &&
                colOpt[3].itemValue
            "
            >{{
              colOpt[3].items.find((item) => item.value === data.roleId)?.text
            }}</span
          >
        </template>
        <template
          #editor="slotProps"
          v-if="editable && colOpt[3].type === 'select'"
        >
          <Dropdown
            class="roles-table__form-dropdown"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            :options="colOpt[3].items"
            :optionLabel="colOpt[3].itemText"
            :optionValue="colOpt[3].itemValue"
            placeholder="select item"
            filter
            @change="
              catchSelectChange(
                $event,
                colOpt[3].field,
                slotProps.data[colOpt[3].identifier]
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
  inject
} from 'vue'
import Column from 'primevue/column'
import DataTable from 'primevue/datatable'
import InputText from 'primevue/inputtext'
import MultiSelect from 'primevue/multiselect'
import Dropdown from 'primevue/dropdown'
import {
  editableRole,
  tableSetting,
  MembersType,
  MembersTextKeys,
  MembersSelectKeys,
  MembersStateKey,
  MembersStateType,
  useState
} from '@/services/members'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { ToastType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

export default defineComponent({
  name: 'RolesTable',
  components: {
    Column,
    DataTable,
    Dropdown,
    // MultiSelect,
    InputText
  },
  setup() {
    const toast = inject(ToastTypeKey) as ToastType
    const columnOptions = reactive(tableSetting)
    const colOpt = reactive(tableSetting)
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const membersService = inject(MembersStateKey) as MembersStateType
    const selectValue = ref<MembersType[]>([]);

    // computed
    const members = computed((): MembersType[] => membersService.state.members)
    const editable = computed((): boolean =>
      authApp.checkAuthority(editableRole)
    )

    const selectedRoles = computed({
      get: (): MembersType[] => selectValue.value,
      set: (value: MembersType[]) => {
        selectValue.value = value
      }
    })

    // created
    /* const created = async () => {}
    created() */

    // watch
    watch(
      () => membersService.state.roles,
      (newValue, old) => {
        if (columnOptions[3].type === 'select') {
          columnOptions[3].items = [...newValue]
        }
        /* ... */
      }
    )

    // methods
    /**
     * catch update text event
     * @param {string} value
     * @param {string} key
     * @param {number} id
     * @return {{id: number, key: string, value: string}}
     */
    const catchTextChange = (value: string, key: string, id: number) => {
      membersService.updateMembersTextValue(id, key as MembersTextKeys, value)
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
      const response = await membersService.updateMembersData(
        id,
        authApp.getHeaderOptions()
      )

      if (response.status !== 304) {
        toast.add(membersService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    /**
     * catch update select event
     * @param {{ originalEvent: Event; value: string | number }} event
     * @param {number} id
     * @param {string} key
     * @return {{id: number, key: string, value: string | null}}
     */
    const catchSelectChange = async (
      event: { originalEvent: Event; value: string | number },
      key: string,
      id: number
    ) => {
      membersService.updateMembersRole(
        id,
        key as MembersSelectKeys,
        event.value as number
      )

      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      const response = await membersService.updateMembersData(
        id,
        authApp.getHeaderOptions()
      )

      if (response.status !== 304) {
        toast.add(membersService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    return {
      members,
      editable,
      catchTextBlurEvent,
      catchTextChange,
      catchSelectChange,
      colOpt,
      selectedRoles,
      columnOptions
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
}
</style>
