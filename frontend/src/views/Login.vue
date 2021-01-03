<template>
  <div class="p-fluid">
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
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import InputText from 'primevue/inputtext'
// import AppInput from '@/components/parts/AppInput.vue'

export default defineComponent({
  name: 'Login',
  components: {
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
