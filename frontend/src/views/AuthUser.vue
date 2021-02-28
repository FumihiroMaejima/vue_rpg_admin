<template>
  <div class="cp-fluid p-mx-md-6 p-mx-sm-2 p-mb-6">
    <h1 class="italic my-2">管理サービス-ログイン管理者情報</h1>
    <h2 class="italic my-2">ログイン管理者データ</h2>

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
import { defineComponent, ref, reactive, inject } from 'vue'
import { useRouter } from 'vue-router'
import AppTable from '@/components/parts/AppTable.vue'
import { tableData, tableKeys } from '@/config/resource'
import { getAuthUserInfo } from '@/services/authinfo'
import AuthApp from '@/plugins/auth/authApp'
import { AuthAppKey } from '@/keys'

// import { AuthAppUtils } from '@/types'

export default defineComponent({
  name: 'AuthUser',
  components: {
    AppTable
  },
  setup() {
    const items = reactive(tableData)
    const columnOptions = reactive(tableKeys)
    const router = useRouter()
    const authApp = inject(AuthAppKey) as AuthApp

    // created
    const created = async () => {
      const data = await getAuthUserInfo(authApp.getHeaderOptions())
      console.log('created event data: ' + JSON.stringify(data, null, 2))
    }
    created()

    // methods
    /**
     * catch app-input event
     * @return {void}
     */
    const catchAppInputEvent = (event: any) => {
      console.log('catchAppInputEvent: ' + JSON.stringify(event, null, 2))
    }

    const testFunction = () => {
      router.push('/test')
    }
    return {
      items,
      columnOptions,
      testFunction,
      catchAppInputEvent
    }
  }
})
</script>
