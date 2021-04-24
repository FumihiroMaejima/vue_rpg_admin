<template>
  <Button
    class="p-button-info"
    label="create"
    icon="pi pi-user"
    @click="display = true"
  />
  <Dialog
    class="member-create-dialog"
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
              class="p-col-fixed member-create-dialog__form-label"
            >
              name
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <span
                  class="p-float-label p-input-icon-right member-create-dialog__form-input"
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
              for="email"
              class="p-col-fixed member-create-dialog__form-label"
            >
              email
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <span
                  class=" p-input-icon-right member-create-dialog__form-input"
                >
                  <InputText
                    id="email"
                    class="p-col-fixed"
                    :class="{ 'p-invalid': emailValue === '' }"
                    name="email"
                    type="text"
                    maxlength="50"
                    placeholder="test@example.com"
                    v-model="emailValue"
                  />
                  <i class="pi pi-envelope" />
                </span>
              </div>
              <small class="p-error">{{ emailError }}</small>
            </div>
          </div>
        </div>

        <div
          class="p-grid p-nogutter p-jc-center p-ai-center vertical-container"
        >
          <div class="p-col-12 p-md-2">
            <label
              for="role"
              class="p-col-fixed member-create-dialog__form-label"
              >role</label
            >
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <Dropdown
                  class="p-col-fixed member-create-dialog__form-dropdown"
                  v-model="roleValue"
                  :options="rolesList"
                  optionLabel="text"
                  optionValue="value"
                  placeholder="select role"
                  filter
                />
              </div>
              <small class="p-error">{{ roleError }}</small>
            </div>
          </div>
        </div>

        <div
          class="p-grid p-nogutter p-jc-center p-ai-center vertical-container"
        >
          <div class="p-col-12 p-md-2">
            <label
              for="password"
              class="p-col-fixed member-create-dialog__form-label"
            >
              password
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <span
                  class="p-float-label p-input-icon-right member-create-dialog__form-input"
                >
                  <InputText
                    id="password"
                    class="p-col-fixed"
                    :class="{ 'p-invalid': passwordValue === '' }"
                    name="password"
                    type="password"
                    v-model="passwordValue"
                  />
                  <i class="pi pi-exclamation-triangle" />
                </span>
              </div>
              <span class="p-error">{{ passwordError }}</span>
            </div>
          </div>
        </div>

        <div
          class="p-grid p-nogutter p-jc-center p-ai-center vertical-container"
        >
          <div class="p-col-12 p-md-2">
            <label
              for="confirmPassword"
              class="p-col-fixed member-create-dialog__form-label"
            >
              confirm password
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <span
                  class="p-float-label p-input-icon-right member-create-dialog__form-input"
                >
                  <InputText
                    id="confirmPassword"
                    class="p-col-fixed"
                    :class="{ 'p-invalid': confirmPasswordValue === '' }"
                    name="confirmPassword"
                    type="password"
                    v-model="confirmPasswordValue"
                  />
                  <i class="pi pi-exclamation-triangle" />
                </span>
              </div>
              <span class="p-error">{{ confirmPasswordError }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="p-grid p-jc-end">
      <div class="p-col-6 p-md-4" style="justify-content:end">
        <div class="p-d-flex p-jc-end">
          <Button
            class="p-button-success p-button-raised"
            icon="pi pi-send"
            label="create"
            :disabled="createDisabled"
            @click="createMemberHandler"
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
import Dropdown from 'primevue/dropdown'

import {
  formSchema,
  MembersStateKey,
  MembersStateType
} from '@/services/members'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { useField, useForm } from 'vee-validate'
import { ToastType, SelectBoxType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

export default defineComponent({
  name: 'RoleCreateDialog',
  components: {
    Button,
    Dialog,
    InputText,
    Dropdown
  },
  setup(__, context: SetupContext) {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const membersService = inject(MembersStateKey) as MembersStateType
    const display = ref<boolean>(false)
    const rolesList = reactive<SelectBoxType[]>([])

    const formContext = useForm({
      validationSchema: formSchema
    })

    const { value: name, errorMessage: nameError } = useField<string>('name')
    const { value: email, errorMessage: emailError } = useField<string>('email')
    const { value: role, errorMessage: roleError } = useField<number>('role')
    const { value: password, errorMessage: passwordError } = useField<string>(
      'password'
    )
    const {
      value: confirmPassword,
      errorMessage: confirmPasswordError
    } = useField<string>('confirmPassword')

    // watch
    watch(
      () => membersService.state.roles,
      (newValue, old) => {
        newValue.forEach((role) => rolesList.push(role))
      }
    )

    // computed
    const nameValue = computed({
      get: (): string => name.value,
      set: (value: string) => {
        name.value = value
      }
    })

    const emailValue = computed({
      get: (): string => email.value,
      set: (value: string) => {
        email.value = value
      }
    })

    const roleValue = computed({
      get: (): number => role.value,
      set: (value: number) => {
        role.value = value
      }
    })

    const passwordValue = computed({
      get: (): string => password.value,
      set: (value: string) => {
        password.value = value
      }
    })

    const confirmPasswordValue = computed({
      get: (): string => confirmPassword.value,
      set: (value: string) => {
        confirmPassword.value = value
      }
    })

    const createDisabled = computed((): boolean => {
      return !(
        nameError.value === '' &&
        emailError.value === '' &&
        roleError.value === '' &&
        passwordError.value === '' &&
        confirmPasswordError.value === ''
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
    const createMemberHandler = async () => {
      display.value = false
      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      const response = await membersService.createMember(
        {
          name: name.value,
          email: email.value,
          roleId: role.value,
          password: password.value,
          password_confirmation: confirmPassword.value
        },
        authApp.getHeaderOptions()
      )
      toast.add(membersService.getToastData())
      if (response.status === 201) {
        formContext.handleReset()
        context.emit('create-member', true)
      }
      inversionFlag(loadingFlag)
    }

    return {
      display,
      rolesList,
      nameValue,
      emailValue,
      roleValue,
      passwordValue,
      confirmPasswordValue,
      nameError,
      emailError,
      roleError,
      passwordError,
      confirmPasswordError,
      createDisabled,
      createMemberHandler
    }
  }
})
</script>
<style lang="scss">
.member-create-dialog {
  width: 45vw;

  &__form-label {
    width: 100%;
  }

  &__form-dropdown {
    width: 100%;
  }

  .member-create-dialog__form-dropdown.p-dropdown {
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
