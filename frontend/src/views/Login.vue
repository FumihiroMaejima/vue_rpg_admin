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
              <span class="p-float-label p-input-icon-right">
                <InputText id="email" type="text" @input="catchAppInputEvent" />
                <i class="pi pi-users" />
                <label for="email">email</label>
                <!-- <i class="pi pi-spin pi-spinner" /> -->
              </span>
            </div>
            <div class="p-field">
              <span class="p-float-label p-input-icon-right">
                <InputText
                  id="password"
                  type="password"
                  @input="catchAppInputEvent"
                />
                <i class="pi pi-exclamation-triangle" />
                <label for="password">password</label>
              </span>
            </div>
          </template>
          <template #footer>
            <Button icon="pi pi-check" label="Sign In" />
            <!-- <Button icon="pi pi-check" label="Sign In" class="p-button-secondary" /> -->
          </template>
        </Card>
      </div>
      <div class="p-col-12 p-md-4"></div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Button from 'primevue/button'
import Card from 'primevue/card'
// import Divider from 'primevue/divider'
import InputText from 'primevue/inputtext'

export default defineComponent({
  name: 'Login',
  components: {
    Button,
    Card,
    InputText
  },
  setup() {
    // methods
    /**
     * catch app-input event
     * @return {void}
     */
    const catchAppInputEvent = (event: any) => {
      console.log('catchAppInputEvent: ' + JSON.stringify(event, null, 2))
    }

    /**
     * catch click event
     * @return {void}
     */
    const onClick = (event: any) => {
      console.log('catch click event: ' + JSON.stringify(event, null, 2))
    }
    return {
      catchAppInputEvent,
      onClick
    }
  }
})
</script>
