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
    </div>

    <div class="p-grid ">
      <div class="p-col-12 p-md-1"></div>
      <div class="p-col-12 p-md-10">
        <app-calender :events="events" initialDate="2021-01-01" />
      </div>
      <div class="p-col-12 p-md-1"></div>
    </div>

    <div class="p-grid ">
      <div class="p-col-12 p-md-1"></div>
      <div class="p-col-12 p-md-10">
        <app-table :items="items.data" :columnOptions="columnOptions" />
      </div>
      <div class="p-col-12 p-md-1"></div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, inject, reactive } from 'vue'
// import Card from '@/components/parts/Card.vue'
// import GridCols from '@/components/parts/GridCols.vue'
// import GridRows from '@/components/parts/GridRows.vue'
// import Dialog from 'primevue/dialog'
import AppCalender from '@/components/parts/AppCalender.vue'
import AppTable from '@/components/parts/AppTable.vue'
import AuthApp from '@/plugins/auth/authApp'
import { tableData, tableKeys, eventDate } from '@/config/resource'

export default defineComponent({
  name: 'Test',
  components: {
    AppCalender,
    AppTable
    // Dialog,
    // Card,
    // GridRows
  },
  setup() {
    const display = ref<boolean>(false)
    const sidebar = ref<boolean>(true)
    const items = reactive(tableData)
    const columnOptions = reactive(tableKeys)
    const events = reactive(eventDate)
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

    return {
      display,
      items,
      columnOptions,
      events,
      sidebar,
      testFunction,
      catchAppInputEvent
    }
  }
})
</script>
