<template>
  <Button label="create" icon="pi pi-external-link" @click="display = true" />
  <Dialog
    header="Member Create Modal"
    v-model:visible="display"
    :modal="true"
    :breakpoints="{ '960px': '90vw' }"
    style="width:75vw;"
  >
    <div class="p-grid p-nogutter">
      <div class="p-col-12 p-md-2"></div>
      <div class="p-col-12 p-md-8">
        <div class="p-field p-grid">
          <label for="name" class="p-col-fixed" style="width:20%">name</label>
          <div class="p-col">
            <span class="p-float-label p-input-icon-right">
              <InputText
                id="name"
                :class="{ 'p-invalid': nameValue === '' }"
                name="name"
                type="text"
                placeholder="input name"
                v-model="nameValue"
              />
              <i class="pi pi-user" />
            </span>
            <small class="p-error">{{ nameError }}</small>
          </div>
        </div>

        <div class="p-field p-grid">
          <label for="email" class="p-col-fixed" style="width:20%">email</label>
          <div class="p-col">
            <span class=" p-input-icon-right">
              <InputText
                id="email"
                :class="{ 'p-invalid': emailValue === '' }"
                name="email"
                type="text"
                placeholder="test@example.com"
                v-model="emailValue"
              />
              <i class="pi pi-envelope" />
            </span>
            <small class="p-error">{{ emailError }}</small>
          </div>
        </div>

        <div class="p-field p-grid">
          <label for="role" class="p-col-fixed" style="width:20%">role</label>
          <div class="p-col">
            <Dropdown
              v-model="roleValue"
              :options="rolesList"
              optionLabel="text"
              optionValue="value"
              placeholder="select role"
              style="width:12rem;"
              filter
            />
            <small class="p-error">{{ roleError }}</small>
          </div>
        </div>

        <div class="p-field p-grid">
          <label for="password" class="p-col-fixed" style="width:20%"
            >password</label
          >
          <div class="p-col">
            <span class="p-float-label p-input-icon-right">
              <InputText
                id="password"
                :class="{ 'p-invalid': passwordValue === '' }"
                name="password"
                type="password"
                v-model="passwordValue"
              />
              <i class="pi pi-exclamation-triangle" />
            </span>
            <span class="p-error">{{ passwordError }}</span>
          </div>
        </div>

        <div class="p-field p-grid">
          <label for="confirmPassword" class="p-col-fixed" style="width:20%"
            >confirm password</label
          >
          <div class="p-col">
            <span class="p-float-label p-input-icon-right">
              <InputText
                id="confirmPassword"
                :class="{ 'p-invalid': confirmPasswordValue === '' }"
                name="confirmPassword"
                type="password"
                v-model="confirmPasswordValue"
              />
              <i class="pi pi-exclamation-triangle" />
            </span>
            <span class="p-error">{{ confirmPasswordError }}</span>
          </div>
        </div>
      </div>
      <div class="p-col-12 p-md-2"></div>
    </div>
    <div class="p-grid p-nogutter">
      <div class="p-col-12 p-md-9"></div>
      <div class="p-col-12 p-md-1">
        <Button class="p-button-raised" icon="pi pi-check" label="create" />
      </div>
      <div class="p-col-12 p-md-2"></div>
    </div>
  </Dialog>
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
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import Dropdown from 'primevue/dropdown'

import {
  editableRole,
  tableSetting,
  MembersType,
  MembersTextKeys,
  MembersSelectKeys,
  MembersStateKey,
  MembersStateType,
  roleItems,
  useState
} from '@/services/members'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { useField, useForm } from 'vee-validate'
import { checkTextLength } from '@/util/validation'
import { ToastType, SelectBoxType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

/* type Props = {
  display: boolean
} */

export default defineComponent({
  name: 'MemberCreateDialog',
  components: {
    Button,
    Dialog,
    InputText,
    Dropdown
  },
  /* props: {
    open: {
      type: Boolean,
      required: false,
      default: false
    }
  }, */
  setup() {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const membersService = inject(MembersStateKey) as MembersStateType
    const display = ref<boolean>(false)
    let rolesList = reactive<SelectBoxType[]>([])

    // watch
    watch(
      () => membersService.state.roles,
      (newValue, old) => {
        rolesList = newValue
      }
    )

    const formSchema = {
      name(value: string): string {
        return checkTextLength(value) ? '' : 'This is required'
      },
      email(value: string): string {
        return checkTextLength(value) ? '' : 'This is required'
      },
      role(value: number): string {
        return rolesList.map((item) => item.value).includes(value)
          ? ''
          : 'not exist value'
      },
      password(value: string): string {
        return checkTextLength(value) ? '' : 'This is required'
      },
      confirmPassword(value: string): string {
        return checkTextLength(value) ? '' : 'This is required'
      }
    }

    useForm({
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

    // computed
    const members = computed((): MembersType[] => membersService.state.members)
    const editable = computed((): boolean =>
      authApp.getAuthAuthority().some((role) => editableRole.includes(role))
    )

    // created
    /* const created = async () => {}
    created() */

    // methods

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
      members,
      editable,
      roleItems
    }
  }
})
</script>
