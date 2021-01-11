<template>
  <Toolbar class="p-py-2">
    <template #left></template>

    <template #right>
      <address class="">
        Copyright(C){{ currentYear }} calicocat.tokyo,Allright Reserved.
      </address>
    </template>
  </Toolbar>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Toolbar from 'primevue/toolbar'

export default defineComponent({
  name: 'GlobalFooter',
  components: {
    Toolbar
  },
  setup() {
    const currentYear = process.env.VUE_APP_CURRENT_YEAR || 2021

    return {
      currentYear
    }
  }
})
</script>
<style lang="scss" scoped></style>
