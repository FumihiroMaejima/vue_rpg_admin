<template>
  <div class="flex items-center justify-center">
    <div class="w-full max-w-md">
      <div class="bg-gray-100 shadow-md rounded mt-8 mb-4">
        <h1 class="italic bg-gray-600 text-white rounded-t-lg px-2 py-2">
          Login Form
        </h1>
        <div class="bg-white shadow-lg rounded px-12 pt-6 pb-8 mb-4">
          <grid-cols :mdCols="1" option="py-2 px-2">
            <app-input
              placeholder="test@example.com"
              @app-input="catchAppInputEvent"
            />
            <app-input
              placeholder="password"
              type="password"
              @app-input="catchAppInputEvent"
            />
            <app-button text="Sign In" color="blue" @click="onClick" />

            <div class="flex items-center justify-between">
              <a
                class="inline-block align-baseline font-normal text-sm text-c-500 hover:text-blue-800"
                href="#"
              >
                Forgot Password?
              </a>
            </div>
          </grid-cols>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import AppButton from '@/components/parts/AppButton.vue'
import AppInput from '@/components/parts/AppInput.vue'
import Card from '@/components/parts/Card.vue'
import GridCols from '@/components/parts/GridCols.vue'
import GridRows from '@/components/parts/GridRows.vue'

export default defineComponent({
  name: 'Login',
  components: {
    AppButton,
    AppInput,
    GridCols
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
