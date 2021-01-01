<template>
  <div class="container mx-auto">
    <h1 class="italic my-2">ゲーム</h1>
    <grid-rows mdRows="1" option="bg-blue-100 py-2 px-2">
      <card />
    </grid-rows>

    <div class="mt-10 grid rounded md:grid-cols-3 sm:grid-cols-1 gap-4"></div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Card from '@/components/parts/Card.vue'
// import GridCols from '@/components/parts/GridCols.vue'
import GridRows from '@/components/parts/GridRows.vue'

export default defineComponent({
  name: 'Home',
  components: {
    Card,
    GridRows
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
    return {
      catchAppInputEvent
    }
  }
})
</script>
