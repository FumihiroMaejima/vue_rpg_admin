<template>
  <Button
    class="p-button-primary p-ml-2"
    label="Import"
    icon="pi pi-user"
    @click="display = true"
  />
  <Dialog
    class="enemies-import-dialog"
    header="Role Remove Modal"
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
              class="p-col-fixed enemies-import-dialog__form-label"
            >
              roles
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <!-- <div>
                <template v-if="rolesNameList.length === 0">
                  <div>
                    no roles selected.
                  </div>
                </template>
                <template v-else>
                  <span
                    class="enemies-import-dialog__chip"
                    v-for="(item, i) of rolesNameList"
                    :key="i"
                  >
                    {{ item }}
                  </span>
                </template>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="p-grid p-jc-end">
      <div class="p-col-6 p-md-12" style="justify-content:end">
        <div class="p-d-flex p-jc-end">
          <Button
            class="p-button-success p-button-raised"
            icon="pi pi-file"
            label="template download"
            @click="downloadTemplateHandler"
          />
        </div>
      </div>
    </div>
    <div class="p-grid p-jc-end">
      <div class="p-col-6 p-md-12" style="justify-content:end">
        <div class="p-d-flex p-jc-end">
          <Button
            class="p-button-primary p-button-raised"
            icon="pi pi-send"
            label="import"
            :disabled="false"
            @click="importEnemiesHandler"
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

import { RolesType, RolesStateKey, RolesStateType } from '@/services/roles'
import { EnemyType, EnemiesStateKey, GameEnemiesStateType } from '@/services/game/enemies'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { useField, useForm } from 'vee-validate'
import { ToastType, SelectBoxType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'


export default defineComponent({
  name: 'EnemiesImportDialog',
  components: {
    Button,
    Dialog
  },
  props: {},
  setup(__, context: SetupContext) {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const rolesService = inject(RolesStateKey) as RolesStateType
    const enemiesService = inject(EnemiesStateKey) as GameEnemiesStateType
    const display = ref<boolean>(false)

    // computed
    /* const rolesNameList = computed((): string[] =>
      props.roles.map((role) => role.name)
    )

    const removeDisabled = computed((): boolean => {
      return !(props.roles.length !== 0)
    }) */

    // created
    /* const created = async () => {}
    created() */

    // methods
    /**
     * catch download event
     * @return {void}
     */
    const downloadTemplateHandler = async () => {
      // display.value = false
      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      const response = await enemiesService.downloadTemplateRequest(
        authApp.getHeaderOptions()
      )
      toast.add(enemiesService.getToastData())
      if (response.status === 200) {
        context.emit('download-template', true)
      }
      inversionFlag(loadingFlag)
    }

    /**
     * catch import enemies event
     * @return {void}
     */
    const importEnemiesHandler = async () => {
      display.value = false
      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      /* const response = await rolesService.removeRoleRequest(
        props.roles.map((role) => role.id),
        authApp.getHeaderOptions()
      )
      toast.add(rolesService.getToastData())
      if (response.status === 200) {
        // formContext.handleReset()
        context.emit('remove-role', true)
      } */
      inversionFlag(loadingFlag)
    }

    return {
      display,
      // rolesList,
      // rolesNameList,
      // removeDisabled,
      downloadTemplateHandler,
      importEnemiesHandler
    }
  }
})
</script>
<style lang="scss">
.enemies-import-dialog {
  width: 45vw;

  &__form-label {
    width: 100%;
  }

  &__form-dropdown {
    width: 100%;
  }

  .enemies-import-dialog__form-dropdown.p-dropdown {
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
