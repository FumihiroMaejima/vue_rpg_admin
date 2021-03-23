<template>
  <div class="cp-fluid p-mx-md-6 p-mx-sm-2 p-mb-6">
    <h1 class="italic my-2">管理サービス-管理者情報</h1>
    <h2 class="italic my-2">管理者一覧</h2>
    <div class="p-grid">
      <div class="p-col-12 p-md-1"></div>
      <div class="p-col-12 p-md-10">
        <div class="p-grid p-jc-end" v-if="editable">
          <div class="p-col-2" style="justify-content:end">
            <div class="p-d-flex p-jc-end">
              <member-create-dialog />
            </div>
          </div>
        </div>
        <div class="p-grid">
          <div class="p-col-12">
            <members-table />
          </div>
        </div>
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
import MemberCreateDialog from '@/components/modules/members/MemberCreateDialog.vue'
import MembersTable from '@/components/modules/members/MembersTable.vue'
import AppTable from '@/components/parts/AppTable.vue'
import {
  editableRole,
  tableSetting,
  MembersType,
  MembersStateKey,
  useState
} from '@/services/members'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { ToastType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

export default defineComponent({
  name: 'Members',
  components: {
    MemberCreateDialog,
    MembersTable
  },
  setup() {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    // const isOpenCreateDialog = ref<boolean>(false)

    const membersService = useState()
    provide(MembersStateKey, membersService)

    // computed
    const editable = computed((): boolean =>
      authApp.getAuthAuthority().some((role) => editableRole.includes(role))
    )

    // created
    const created = async () => {
      inversionFlag(loadingFlag)

      const roleListData = await membersService.getRoles(
        authApp.getHeaderOptions()
      )
      const response = await membersService.getMembersData(
        authApp.getHeaderOptions()
      )
      if (response.status !== 200 || roleListData.status !== 200) {
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
      editable,
      catchAppInputEvent
    }
  }
})
</script>
