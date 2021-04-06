<template>
  <div class="cp-fluid p-mx-md-6 p-mx-sm-2 p-mb-6">
    <h1 class="italic my-2">管理サービス-管理者情報</h1>
    <h2 class="italic my-2">管理者一覧</h2>
    <div class="p-grid">
      <div class="p-col-12 p-md-1"></div>
      <div class="p-col-12 p-md-10">
        <div class="p-grid p-jc-end" v-if="editable">
          <div class="p-col-10 p-md-8" style="justify-content:end">
            <div class="p-d-flex p-jc-end">
              <member-remove-dialog
                @remove-member="removeMemberHandler"
                :members="membersNameList"
              />
              <Button
                class="p-button-success p-mr-2"
                label="download"
                icon="pi pi-file"
                @click="downloadFileHandler"
              />
              <member-create-dialog @create-member="createMemberHandler" />
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
import { defineComponent, Ref, computed, provide, inject } from 'vue'
import Button from 'primevue/button'
import MemberCreateDialog from '@/components/modules/members/MemberCreateDialog.vue'
import MemberRemoveDialog from '@/components/modules/members/MemberRemoveDialog.vue'
import MembersTable from '@/components/modules/members/MembersTable.vue'
import {
  editableRole,
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
    Button,
    MemberCreateDialog,
    MemberRemoveDialog,
    MembersTable
  },
  setup() {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp

    const membersService = useState()
    provide(MembersStateKey, membersService)

    // computed
    const editable = computed((): boolean =>
      authApp.checkAuthority(editableRole)
    )

    const membersNameList = computed((): Pick<MembersType, 'id' | 'name'>[] =>
      membersService.state.members.map((member) => {
        return { id: member.id, name: member.name }
      })
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
      inversionFlag(loadingFlag)
    }
    created()

    // methods
    /**
     * handling create member event
     * @param {boolean} event
     * @return {void}
     */
    const createMemberHandler = async (event: boolean) => {
      inversionFlag(loadingFlag)
      const response = await membersService.getMembersData(
        authApp.getHeaderOptions()
      )
      if (response.status !== 200) {
        toast.add(membersService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    /**
     * handling remove member event
     * @param {boolean} event
     * @return {void}
     */
    const removeMemberHandler = async (event: boolean) => {
      inversionFlag(loadingFlag)
      const response = await membersService.getMembersData(
        authApp.getHeaderOptions()
      )
      if (response.status !== 200) {
        toast.add(membersService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    /**
     * handling create member event
     * @param {boolean} event
     * @return {void}
     */
    const downloadFileHandler = async () => {
      inversionFlag(loadingFlag)
      const response = await membersService.downloadMemberCSV(
        authApp.getHeaderOptions()
      )
      if (response.status !== 304) {
        toast.add(membersService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    return {
      membersNameList,
      editable,
      createMemberHandler,
      removeMemberHandler,
      downloadFileHandler
    }
  }
})
</script>
