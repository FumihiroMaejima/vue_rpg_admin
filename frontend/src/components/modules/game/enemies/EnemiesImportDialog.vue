<template>
  <Button
    class="p-button-primary p-ml-2"
    label="Import"
    icon="pi pi-users"
    @click="display = true"
  />
  <Dialog
    class="enemies-import-dialog"
    header="Template Import Modal"
    v-model:visible="display"
    :modal="true"
    :breakpoints="{ '960px': '90vw' }"
  >
    <div class="p-grid p-nogutter p-jc-center p-ai-center vertical-container">
      <div class="p-col-12 p-md-2">
        <label
          for="template"
          class="p-col-fixed enemies-import-dialog__form-label"
        >
          template
        </label>
      </div>
      <div class="p-col-12 p-md-10">
        <div class="p-col p-pr-0">
          <div class="p-d-flex p-jc-end">
            <Button
              class="p-button-success p-button-raised"
              :icon="iconValue"
              label="download"
              @click="downloadTemplateHandler"
            />
          </div>
        </div>
      </div>
    </div>

    <div class="p-grid p-nogutter p-jc-center p-ai-center vertical-container">
      <div class="p-col-12 p-md-2">
        <label
          for="upload"
          class="p-col-fixed enemies-import-dialog__form-label"
        >
          upload
        </label>
      </div>
      <div class="p-col-12 p-md-10">
        <div class="p-col p-pr-0">
          <AppFileInput
            :value="fileDataValue"
            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            @update:value="catchSelectFileHandler"
            @reset-file="catchResetFileHandler"
          />
        </div>
      </div>
    </div>

    <div class="p-grid p-jc-end">
      <div class="p-col-6 p-md-12" style="justify-content:end">
        <div class="p-d-flex p-jc-end">
          <Button
            class="p-button-primary p-button-raised"
            icon="pi pi-cloud-upload"
            label="import"
            :disabled="importDisabled"
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
import AppFileInput from '@/components/parts/AppFileInput.vue'

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

export default defineComponent({
  name: 'EnemiesImportDialog',
  components: {
    AppFileInput,
    Button,
    Dialog
  },
  props: {},
  setup(__, context: SetupContext) {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const enemiesService = inject(EnemiesStateKey) as GameEnemiesStateType
    const display = ref<boolean>(false)
    const fileData = ref<undefined | File>(undefined)

    // computed
    const iconValue = computed((): string =>
      loadingFlag.value ? 'pi pi-spin pi-spinner' : 'pi pi-cloud-download'
    )

    const fileDataValue = computed((): undefined | File => fileData.value)

    const importDisabled = computed((): boolean => {
      return fileData.value === undefined
    })

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
     * catch select file event
     * @param {File} file
     * @return {void}
     */
    const catchSelectFileHandler = async (file: File) => {
      fileData.value = file
      const data = new FormData()
      data.append('file', file)
    }

    /**
     * catch reset file event
     * @return {void}
     */
    const catchResetFileHandler = () => {
      fileData.value = undefined
    }

    /**
     * catch import enemies event
     * @return {void}
     */
    const importEnemiesHandler = async () => {
      display.value = false
      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      const data = new FormData()
      data.append('file', fileData.value as File)
      const response = await enemiesService.importEnemiesRequest(
        data,
        authApp.getHeaderOptions()
      )
      toast.add(enemiesService.getToastData())
      if (response.status === 201) {
        // formContext.handleReset()
        catchResetFileHandler()
        context.emit('import-enemies', true)
      }
      inversionFlag(loadingFlag)
    }

    return {
      fileDataValue,
      display,
      iconValue,
      catchSelectFileHandler,
      catchResetFileHandler,
      importDisabled,
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

  &__file-upload-button {
    .p-fileupload-choose-selected.p-fileupload-choose {
      // pointer-events: none;
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
