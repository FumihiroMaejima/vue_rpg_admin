<template>
  <div class="cp-fluid p-mx-md-6 p-mx-sm-2 p-mb-6">
    <h1 class="italic my-2">管理サービス-管理者情報</h1>
    <h2 class="italic my-2">管理者一覧</h2>

    <div class="p-grid">
      <div class="p-col-12 p-md-1"></div>
      <div class="p-col-12 p-md-10">
        <members-table />
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
import MembersTable from '@/components/modules/members/MembersTable.vue'
import AppTable from '@/components/parts/AppTable.vue'
import {
  tableSetting,
  MembersType,
  MembersStateKey,
  useState
} from '@/services/members'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { ToastType } from '@/types/components/index'
import { ToastTypeKey, CircleLoadingKey } from '@/keys'

export default defineComponent({
  name: 'Members',
  components: {
    AppTable,
    MembersTable
  },
  setup() {
    const toast = inject(ToastTypeKey) as ToastType
    const columnOptions = reactive(tableSetting)
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject('authApp') as AuthApp

    const membersService = useState()
    provide(MembersStateKey, membersService)

    // computed
    const members = computed((): MembersType[] => membersService.state.members)

    // created
    const created = async () => {
      inversionFlag(loadingFlag)
      const response = await membersService.getMembersData(
        authApp.getHeaderOptions()
      )
      if (response.status !== 200) {
        toast.add(membersService.getToastData())
      }
      /* console.log(
        'membersService.getMembersData(): ' +
          JSON.stringify(membersService.getMembersData(), null, 2)
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

    return {
      members,
      columnOptions,
      catchAppInputEvent
    }
  }
})
</script>
