<template>
  <div class="p-fluid p-py-6 p-mb-6">
    <div class="p-grid p-nogutter">
      <div class="p-col-12 p-md-4"></div>
      <div class="p-col-12 p-md-4">
        <Card>
          <!-- <template #header></template> -->
          <template #title>
            Login Form <i class="pi pi-check-square" />
          </template>
          <template #content>
            <div class="p-field p-my-4">
              <label for="email">email</label>
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
            <div class="p-field">
              <label for="password">password</label>
              <span class="p-float-label p-input-icon-right">
                <InputText
                  id="password"
                  :class="{ 'p-invalid': passwordlValue === '' }"
                  name="password"
                  type="password"
                  v-model="passwordlValue"
                />
                <i class="pi pi-exclamation-triangle" />
              </span>
              <span class="p-error">{{ passwordError }}</span>
            </div>
          </template>
          <template #footer>
            <Button
              class="p-button-raised"
              :icon="iconValue"
              :label="buttonText"
              @click="loginAction"
            />
          </template>
        </Card>
      </div>
      <div class="p-col-12 p-md-4"></div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject, computed, Ref } from 'vue'
import Button from 'primevue/button'
import Card from 'primevue/card'
import InputText from 'primevue/inputtext'
import { useField, useForm } from 'vee-validate'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { checkTextLength } from '@/util/validation'
import { ToastType } from '@/types'
import { ToastTypeKey, CircleLoadingKey } from '@/keys'

export default defineComponent({
  name: 'Login',
  components: {
    Button,
    Card,
    InputText
  },
  setup() {
    const toast = inject(ToastTypeKey) as ToastType
    const loginSchema = {
      email(value: string): string {
        return checkTextLength(value) ? '' : 'This is required'
      },
      password(value: string): string {
        return checkTextLength(value) ? '' : 'This is required'
      }
    }

    useForm({
      validationSchema: loginSchema
    })

    const { value: email, errorMessage: emailError } = useField<string>('email')
    const { value: password, errorMessage: passwordError } = useField<string>(
      'password'
    )
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject('authApp') as AuthApp

    // computed
    const emailValue = computed({
      get: (): string => email.value,
      set: (value: string) => {
        email.value = value
      }
    })

    const passwordlValue = computed({
      get: (): string => password.value,
      set: (value: string) => {
        password.value = value
      }
    })

    const iconValue = computed((): string =>
      loadingFlag.value ? 'pi pi-spin pi-spinner' : 'pi pi-check'
    )

    const buttonText = computed((): string =>
      loadingFlag.value ? 'Now Loading...' : 'Sign In'
    )

    // methods
    /**
     * catch click event
     * @return {void}
     */
    const loginAction = async () => {
      inversionFlag(loadingFlag)

      const response = await authApp.login(email.value, password.value)
      inversionFlag(loadingFlag)
      toast.add({
        severity: response ? 'success' : 'error',
        summary: `Login ${response ? 'Success' : 'Failed'}`,
        detail: `Login Request is ${response ? 'Success' : 'Failed'}.`,
        life: 5000
      })
    }
    return {
      loadingFlag,
      emailValue,
      passwordlValue,
      emailError,
      passwordError,
      iconValue,
      buttonText,
      loginAction
    }
  }
})
</script>
