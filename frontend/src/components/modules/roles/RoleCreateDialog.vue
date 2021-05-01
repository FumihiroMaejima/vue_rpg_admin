<template>
  <Button
    class="p-button-info"
    label="create"
    icon="pi pi-user"
    @click="display = true"
  />
  <Dialog
    class="role-create-dialog"
    header="Member Create Modal"
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
              for="name"
              class="p-col-fixed role-create-dialog__form-label"
            >
              name
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <span
                  class="p-float-label p-input-icon-right role-create-dialog__form-input"
                >
                  <InputText
                    id="name"
                    class="p-col-fixed"
                    :class="{ 'p-invalid': nameValue === '' }"
                    name="name"
                    type="text"
                    maxlength="50"
                    placeholder="input name"
                    v-model="nameValue"
                  />
                  <i class="pi pi-user" />
                </span>
              </div>
              <small class="p-error">{{ nameError }}</small>
            </div>
          </div>
        </div>

        <div
          class="p-grid p-nogutter p-jc-center p-ai-center vertical-container"
        >
          <div class="p-col-12 p-md-2">
            <label
              for="code"
              class="p-col-fixed role-create-dialog__form-label"
            >
              code
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <span
                  class="p-float-label p-input-icon-right role-create-dialog__form-input"
                >
                  <InputText
                    id="code"
                    class="p-col-fixed"
                    :class="{ 'p-invalid': codeValue === '' }"
                    name="code"
                    type="text"
                    maxlength="50"
                    placeholder="input code"
                    v-model="codeValue"
                  />
                  <i class="pi pi-user" />
                </span>
              </div>
              <small class="p-error">{{ codeError }}</small>
            </div>
          </div>
        </div>

        <div
          class="p-grid p-nogutter p-jc-center p-ai-center vertical-container"
        >
          <div class="p-col-12 p-md-2">
            <label
              for="name"
              class="p-col-fixed role-create-dialog__form-label"
            >
              detail
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <span
                  class="p-float-label p-input-icon-right role-create-dialog__form-input"
                >
                  <InputText
                    id="detail"
                    class="p-col-fixed"
                    :class="{ 'p-invalid': detailValue === '' }"
                    name="detail"
                    type="text"
                    maxlength="50"
                    placeholder="input detail"
                    v-model="detailValue"
                  />
                  <i class="pi pi-user" />
                </span>
              </div>
              <small class="p-error">{{ detailError }}</small>
            </div>
          </div>
        </div>

        <div
          class="p-grid p-nogutter p-jc-center p-ai-center vertical-container"
        >
          <div class="p-col-12 p-md-2">
            <label for="role" class="p-col-fixed role-create-dialog__form-label"
              >permissions</label
            >
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <MultiSelect
                  class="p-col-fixed role-create-dialog__form-dropdown"
                  v-model="permissionsValue"
                  :options="permissionsList"
                  optionLabel="text"
                  optionValue="value"
                  placeholder="select role"
                  filter
                />
              </div>
              <small class="p-error">{{ permissionsError }}</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="p-grid p-jc-end p-pr-2">
      <div class="p-col-6 p-md-4" style="justify-content:end">
        <div class="p-d-flex p-jc-end">
          <Button
            class="p-button-success p-button-raised"
            icon="pi pi-send"
            label="create"
            :disabled="createDisabled"
            @click="createRoleHandler"
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
  reactive,
  computed,
  SetupContext,
  watch,
  inject
} from 'vue'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import MultiSelect from 'primevue/multiselect'

import { formSchema, RolesStateKey, RolesStateType } from '@/services/roles'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { useField, useForm } from 'vee-validate'
import { ToastType, SelectBoxType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

export default defineComponent({
  name: 'RoleCreateDialog',
  components: {
    Button,
    MultiSelect,
    Dialog,
    InputText
  },
  setup(__, context: SetupContext) {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const rolesService = inject(RolesStateKey) as RolesStateType
    const display = ref<boolean>(false)
    const permissionsList = reactive<SelectBoxType[]>([])

    const formContext = useForm({
      validationSchema: formSchema
    })

    const { value: name, errorMessage: nameError } = useField<string>('name')
    const { value: code, errorMessage: codeError } = useField<string>('code')
    const { value: detail, errorMessage: detailError } = useField<string>(
      'detail'
    )
    const { value: permissions, errorMessage: permissionsError } = useField<
      number[]
    >('permissions')

    // watch
    watch(
      () => rolesService.state.permissions,
      (newValue, old) => {
        newValue.forEach((permission) => permissionsList.push(permission))
      }
    )

    // computed
    const nameValue = computed({
      get: (): string => name.value,
      set: (value: string) => {
        name.value = value
      }
    })

    const codeValue = computed({
      get: (): string => code.value,
      set: (value: string) => {
        code.value = value
      }
    })

    const detailValue = computed({
      get: (): string => detail.value,
      set: (value: string) => {
        detail.value = value
      }
    })

    const permissionsValue = computed({
      get: (): number[] => permissions.value,
      set: (value: number[]) => {
        permissions.value = value
      }
    })

    const createDisabled = computed((): boolean => {
      return !(
        nameError.value === '' &&
        codeError.value === '' &&
        detailError.value === '' &&
        permissionsError.value === ''
      )
    })

    // created
    /* const created = async () => {}
    created() */

    // methods
    /**
     * catch create member event
     * @return {void}
     */
    const createRoleHandler = async () => {
      display.value = false
      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      const response = await rolesService.createRole(
        {
          name: name.value,
          code: code.value,
          detail: detail.value,
          permissions: permissions.value
        },
        authApp.getHeaderOptions()
      )
      toast.add(rolesService.getToastData())
      if (response.status === 201) {
        formContext.handleReset()
        context.emit('create-role', true)
      }
      inversionFlag(loadingFlag)
    }

    return {
      display,
      permissionsList,
      nameValue,
      codeValue,
      detailValue,
      permissionsValue,
      nameError,
      codeError,
      detailError,
      permissionsError,
      createDisabled,
      createRoleHandler
    }
  }
})
</script>
<style lang="scss">
.role-create-dialog {
  width: 45vw;

  &__form-label {
    width: 100%;
    word-break: break-all;
  }

  &__form-dropdown {
    width: 100%;
  }

  .role-create-dialog__form-dropdown.p-dropdown {
    padding: 0 0 0 0 !important;
  }

  .role-create-dialog__form-dropdown.p-multiselect {
    padding: 0 0 0 0 !important;
  }

  &__form-input {
    width: 100%;
    input {
      width: 100%;
    }
  }
}
</style>
