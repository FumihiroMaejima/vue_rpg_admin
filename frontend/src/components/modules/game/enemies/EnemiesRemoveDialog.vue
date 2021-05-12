<template>
  <Button
    class="p-button-danger p-mr-2"
    label="Remove"
    icon="pi pi-user"
    @click="display = true"
  />
  <Dialog
    class="enemies-remove-dialog"
    header="Enemies Remove Modal"
    v-model:visible="display"
    :modal="true"
    :breakpoints="{ '960px': '90vw' }"
  >
    <div class="p-grid p-nogutter p-jc-center">
      <div class="p-col-12">
        <div
          class="p-grid p-nogutter p-jc-center p-ai-center vertical-container"
        >
          <div class="p-col-12 p-md-2">
            <label
              for="role"
              class="p-col-fixed enemies-remove-dialog__form-label"
            >
              enemies
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <template v-if="enemiesNameList.length === 0">
                  <div>
                    no enemy selected.
                  </div>
                </template>
                <template v-else>
                  <span
                    class="enemies-remove-dialog__chip"
                    v-for="(item, i) of enemiesNameList"
                    :key="i"
                  >
                    {{ item }}
                  </span>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="p-grid p-jc-end">
      <div class="p-col-6 p-md-4" style="justify-content:end">
        <div class="p-d-flex p-jc-end">
          <Button
            class="p-button-danger p-button-raised"
            icon="pi pi-send"
            label="remove"
            :disabled="removeDisabled"
            @click="removeEnemiesHandler"
          />
        </div>
      </div>
    </div>
  </Dialog>
</template>

<script lang="ts">
/* eslint-disable @typescript-eslint/camelcase */
import {
  defineComponent,
  ref,
  Ref,
  PropType,
  reactive,
  computed,
  SetupContext,
  watch,
  inject
} from 'vue'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import Dropdown from 'primevue/dropdown'

import {
  EnemyType,
  EnemiesStateKey,
  GameEnemiesStateType
} from '@/services/game/enemies'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { useField, useForm } from 'vee-validate'
import { ToastType, SelectBoxType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

type Props = {
  enemies: EnemyType[]
}

export default defineComponent({
  name: 'EnemiesRemoveDialog',
  components: {
    Button,
    Dialog /* ,
    Dropdown */
  },
  props: {
    enemies: {
      type: Array as PropType<EnemyType[]>,
      required: false,
      default: () => {
        return []
      }
    }
  },
  setup(props: Props, context: SetupContext) {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const enemiesService = inject(EnemiesStateKey) as GameEnemiesStateType
    const display = ref<boolean>(false)

    // computed
    const enemiesNameList = computed((): string[] =>
      props.enemies.map((enemy) => enemy.name)
    )

    const removeDisabled = computed((): boolean => {
      return !(props.enemies.length !== 0)
    })

    // created
    /* const created = async () => {}
    created() */

    // methods
    /**
     * catch remove enemy event
     * @return {void}
     */
    const removeEnemiesHandler = async () => {
      display.value = false
      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      const response = await enemiesService.removeEnemiesRequest(
        props.enemies.map((enemy) => enemy.id),
        authApp.getHeaderOptions()
      )
      toast.add(enemiesService.getToastData())
      if (response.status === 200) {
        // formContext.handleReset()
        context.emit('remove-enemies', true)
      }
      inversionFlag(loadingFlag)
    }

    return {
      display,
      enemiesNameList,
      removeDisabled,
      removeEnemiesHandler
    }
  }
})
</script>
<style lang="scss">
.enemies-remove-dialog {
  width: 45vw;

  &__form-label {
    width: 100%;
  }

  &__form-dropdown {
    width: 100%;
  }

  .enemies-remove-dialog__form-dropdown.p-dropdown {
    padding: 0 0 0 0 !important;
  }

  &__form-input {
    width: 100%;
    input {
      width: 100%;
    }
  }

  &__chip {
    display: inline-flex;
    margin: 2px 2px;
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
