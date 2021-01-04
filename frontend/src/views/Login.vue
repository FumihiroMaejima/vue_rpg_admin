<template>
  <div class="p-fluid p-py-4">
    <div class="p-grid">
      <div class="p-col-12 p-md-4"></div>
      <div class="p-col-12 p-md-4">
        <Card>
          <!-- <template #header></template> -->
          <template #title>
            Login Form
          </template>
          <template #content>
            <div class="p-field">
              <label for="email">email</label>
              <InputText
                id="email"
                type="text"
                placeholder="test@example.com"
                @input="catchAppInputEvent"
              />
            </div>
            <div class="p-field">
              <label for="password">password</label>
              <InputText
                id="password"
                type="password"
                placeholder="password"
                @input="catchAppInputEvent"
              />
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
// import AppInput from '@/components/parts/AppInput.vue'

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
