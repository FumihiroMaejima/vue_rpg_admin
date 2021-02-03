<template>
  <div class="container mx-auto">
    <h1 class="italic my-2">ゲーム</h1>
    <i class="pi pi-check"></i>
    <i class="pi pi-github"></i>
    <div class="p-grid">
      <div class="p-col-12 p-md-6 p-lg-3"><i class="pi pi-check"></i></div>
      <div class="p-col-12 p-md-6 p-lg-3"><i class="pi pi-github"></i></div>
      <div class="p-col-12 p-md-6 p-lg-3"><i class="pi pi-check"></i></div>
      <div class="p-col-12 p-md-6 p-lg-3"><i class="pi pi-github"></i></div>
      <div class="p-col-12 p-md-6 p-lg-3">
        <button @click="testFunction">back to root</button>
      </div>
      <div class="p-col-12 p-md-6 p-lg-3">
        <button @click="logoutFunction">Sign Out</button>
      </div>
    </div>
    <!-- <Dialog header="Header" v-model:visible="display">content</Dialog> -->
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, inject } from 'vue'
// import Card from '@/components/parts/Card.vue'
// import GridCols from '@/components/parts/GridCols.vue'
// import GridRows from '@/components/parts/GridRows.vue'
// import Dialog from 'primevue/dialog'
import AuthApp from '@/plugins/auth/authApp'

export default defineComponent({
  name: 'Test',
  components: {
    // Dialog,
    // Card,
    // GridRows
  },
  setup() {
    const display = ref<boolean>(false)
    const sidebar = ref<boolean>(true)
    const authApp = inject('authApp') as AuthApp

    // methods
    /**
     * catch app-input event
     * @return {void}
     */
    const catchAppInputEvent = (event: any) => {
      console.log('catchAppInputEvent: ' + JSON.stringify(event, null, 2))
    }

    const testFunction = () => {
      authApp.router.push('/')
    }

    const logoutFunction = async () => {
      await authApp.logout()
    }

    return {
      display,
      sidebar,
      testFunction,
      logoutFunction,
      catchAppInputEvent
    }
  }
})
</script>
