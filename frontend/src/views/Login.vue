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
                <InputText id="email" type="text" v-model="emailValue" />
                <i class="pi pi-envelope" />
                <!-- <i class="pi pi-spin pi-spinner" /> -->
              </span>
            </div>
            <div class="p-field">
              <label for="password">password</label>
              <span class="p-float-label p-input-icon-right">
                <InputText
                  id="password"
                  type="password"
                  v-model="passwordlValue"
                />
                <i class="pi pi-exclamation-triangle" />
              </span>
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
import { defineComponent, inject, computed, ref } from 'vue'
import Button from 'primevue/button'
import Card from 'primevue/card'
// import Divider from 'primevue/divider'
import InputText from 'primevue/inputtext'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'

export default defineComponent({
  name: 'Login',
  components: {
    Button,
    Card,
    InputText
  },
  setup() {
    const email = ref<string>('')
    const password = ref<string>('')
    const loadingFlag = ref<boolean>(false)
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
      loadingFlag.value ? 'Now Loading' : 'Sign In'
    )

    // methods
    /**
     * catch click event
     * @return {void}
     */
    const loginAction = async () => {
      inversionFlag(loadingFlag)
      await authApp.login(email.value, password.value)
      inversionFlag(loadingFlag)
    }
    return {
      loadingFlag,
      emailValue,
      passwordlValue,
      iconValue,
      buttonText,
      loginAction
    }
  }
})
</script>
