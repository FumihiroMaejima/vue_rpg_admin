<template>
  <div class="cp-fluid p-mx-md-6 p-mx-sm-2 p-mb-6">
    <h1 class="italic my-2">管理サービス</h1>
    <h2 class="italic my-2">管理者ログ</h2>

    <div class="p-grid">
      <div class="p-col-12 p-md-1"></div>
      <div class="p-col-12 p-md-10">
        <app-table :items="items.data" :columnOptions="columnOptions" />
      </div>
      <div class="p-col-12 p-md-1"></div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import AppTable from '@/components/parts/AppTable.vue'
import { tableData, tableKeys } from '@/config/resource'

export default defineComponent({
  name: 'Home',
  components: {
    AppTable
  },
  setup() {
    const items = reactive(tableData)
    const columnOptions = reactive(tableKeys)
    const router = useRouter()

    // methods

    const testFunction = () => {
      router.push('/test')
    }
    return {
      items,
      columnOptions,
      testFunction
    }
  }
})
</script>
