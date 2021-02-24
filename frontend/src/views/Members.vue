<template>
  <div class="cp-fluid p-mx-md-6 p-mx-sm-2 p-mb-6">
    <h1 class="italic my-2">管理サービス-管理者情報</h1>
    <h2 class="italic my-2">管理者一覧</h2>

    <div class="p-grid">
      <div class="p-col-12 p-md-1"></div>
      <div class="p-col-12 p-md-10">
        <app-table :items="members" :columnOptions="columnOptions" />
      </div>
      <div class="p-col-12 p-md-1"></div>
    </div>
  </div>
</template>

<script lang="ts">
import {
  defineComponent,
  ref,
  Ref,
  PropType,
  reactive,
  computed,
  provide,
  inject
} from 'vue'
import { useRouter } from 'vue-router'
import AppTable from '@/components/parts/AppTable.vue'
import {
  tableKeys,
  MembersType,
  StateKey,
  useState
} from '@/services/members'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { ToastType } from '@/types/components/index'

export default defineComponent({
  name: 'Members',
  components: {
    AppTable
  },
  setup() {
    const toast = inject('toast') as ToastType
    const columnOptions = reactive(tableKeys)
    const router = useRouter()
    const loadingFlag = inject('circleLoading') as Ref<boolean>
    const authApp = inject('authApp') as AuthApp

    const service = useState()
    provide('service', service)

    // computed
    const members = computed((): MembersType[] => service.state.members)

    // created
    const created = async () => {
      inversionFlag(loadingFlag)
      const response = await service.getMembers(authApp.getHeader())
      if (response.status !== 200) {
        toast.add({
          severity: 'error',
          summary: `データ取得エラー`,
          detail: `データの取得に失敗しました。`,
          life: 5000
        })
      }
      /* console.log(
        'service.getMembersData(): ' +
          JSON.stringify(service.getMembersData(), null, 2)
      ) */
      inversionFlag(loadingFlag)
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
      members,
      columnOptions,
      testFunction,
      catchAppInputEvent
    }
  }
})
</script>
