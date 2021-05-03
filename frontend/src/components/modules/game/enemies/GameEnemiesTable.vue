<template>
  <div>
    <DataTable
      :value="enemies"
      v-model:selection="selectedEnemies"
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
        No Enemy found.
      </template>
      <template #loading>
        Loading enemy data. Please wait.
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
          <div>
            {{ data.name }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="game-enemies-table__form-input"
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
          <div>
            {{ data.level }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="game-enemies-table__form-input"
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
          <div>
            {{ data.hp }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="game-enemies-table__form-input"
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
          <div>
            {{ data.mp }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="game-enemies-table__form-input"
            type="text"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            @blur="
              catchTextBlurEvent(
                $event,
                colOpt[4].field,
                slotProps.data[colOpt[4].identifier]
              )
            "
            @update:modelValue="
              catchTextChange(
                $event,
                colOpt[4].field,
                slotProps.data[colOpt[4].identifier]
              )
            "
          />
        </template>
      </Column>

      <Column
        :field="colOpt[5].field"
        :header="colOpt[5].header"
        :sortable="true"
        :style="colOpt[5].style"
      >
        <template #body="{data}">
          <div>
            {{ data.offence }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="game-enemies-table__form-input"
            type="text"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            @blur="
              catchTextBlurEvent(
                $event,
                colOpt[5].field,
                slotProps.data[colOpt[5].identifier]
              )
            "
            @update:modelValue="
              catchTextChange(
                $event,
                colOpt[5].field,
                slotProps.data[colOpt[5].identifier]
              )
            "
          />
        </template>
      </Column>

      <Column
        :field="colOpt[6].field"
        :header="colOpt[6].header"
        :sortable="true"
        :style="colOpt[6].style"
      >
        <template #body="{data}">
          <div>
            {{ data.defense }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="game-enemies-table__form-input"
            type="text"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            @blur="
              catchTextBlurEvent(
                $event,
                colOpt[6].field,
                slotProps.data[colOpt[6].identifier]
              )
            "
            @update:modelValue="
              catchTextChange(
                $event,
                colOpt[6].field,
                slotProps.data[colOpt[6].identifier]
              )
            "
          />
        </template>
      </Column>

      <Column
        :field="colOpt[7].field"
        :header="colOpt[7].header"
        :sortable="true"
        :style="colOpt[7].style"
      >
        <template #body="{data}">
          <div>
            {{ data.speed }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="game-enemies-table__form-input"
            type="text"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            @blur="
              catchTextBlurEvent(
                $event,
                colOpt[7].field,
                slotProps.data[colOpt[7].identifier]
              )
            "
            @update:modelValue="
              catchTextChange(
                $event,
                colOpt[7].field,
                slotProps.data[colOpt[7].identifier]
              )
            "
          />
        </template>
      </Column>

      <Column
        :field="colOpt[8].field"
        :header="colOpt[8].header"
        :sortable="true"
        :style="colOpt[8].style"
      >
        <template #body="{data}">
          <div>
            {{ data.magic }}
          </div>
        </template>
        <template #editor="slotProps" v-if="editable">
          <InputText
            class="game-enemies-table__form-input"
            type="text"
            :modelValue="slotProps.data[slotProps.column.props.field]"
            @blur="
              catchTextBlurEvent(
                $event,
                colOpt[8].field,
                slotProps.data[colOpt[8].identifier]
              )
            "
            @update:modelValue="
              catchTextChange(
                $event,
                colOpt[8].field,
                slotProps.data[colOpt[8].identifier]
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
  editableRole,
  tableSetting,
  EnemyType,
  EnemyTextKeys,
  EnemyNumberKeys,
  EnemySelectKeys,
  EnemiesStateKey,
  GameEnemiesStateType
  // useState
} from '@/services/game/enemies'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag, getMultiSelectLabel, InvalidStateErrorUtil } from '@/util'
import { ToastType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

type Props = {
  selectEnemies: EnemyType[]
}

export default defineComponent({
  name: 'GameEnemiesTable',
  components: {
    Column,
    DataTable,
    // Dropdown,
    // MultiSelect,
    InputText
  },
  props: {
    selectEnemies: {
      type: Array as PropType<EnemyType[]>,
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
    const gameEnemiesService = inject(EnemiesStateKey) as GameEnemiesStateType

    // computed
    const enemies = computed((): EnemyType[] => gameEnemiesService.state.enemies)
    const editable = computed((): boolean =>
      authApp.checkAuthority(editableRole)
    )

    const selectedEnemies = computed({
      get: (): EnemyType[] => props.selectEnemies,
      set: (value: EnemyType[]) => {
        context.emit('update:selectEnemies', value)
      }
    })

    // created
    /* const created = async () => {}
    created() */

    // methods
    /**
     * catch update text event
     * @param {string | number} value
     * @param {string} key
     * @param {number} id
     * @return {void}
     */
    const catchTextChange = (value: string | number, key: string, id: number) => {

      if (typeof value === 'string') {
        gameEnemiesService.updateStateTextValue(id, key as EnemyTextKeys, value)
      } else if (typeof value === 'number') {
        gameEnemiesService.updateStateNumberValue(id, key as EnemyNumberKeys, value)
      } else {
        throw new InvalidStateErrorUtil(value as never, `invalid value of ${value}`)
      }
    }

    /**
     * catch update text event
     * @param {Event} event
     * @param {string} key
     * @param {number} id
     * @return {void}
     */
    const catchTextBlurEvent = async (
      event: Event,
      key: string,
      id: number
    ) => {
      inversionFlag(loadingFlag)
      const response = await gameEnemiesService.updateEnemiesRequest(
        id,
        authApp.getHeaderOptions()
      )

      if (response.status !== 304) {
        toast.add(gameEnemiesService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    return {
      getMultiSelectLabel,
      enemies,
      editable,
      catchTextBlurEvent,
      catchTextChange,
      colOpt,
      selectedEnemies
    }
  }
})
</script>
<style lang="scss">
.game-enemies-table {
  &__form-dropdown {
    width: 100%;
  }

  .game-enemies-table__form-dropdown.p-dropdown {
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
