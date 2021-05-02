<template>
  <div class="cp-fluid p-mx-md-6 p-mx-sm-2 p-mb-6">
    <h1 class="italic my-2">管理サービス-権限情報</h1>
    <h2 class="italic my-2">ロール一覧</h2>
    <div class="p-grid">
      <div class="p-col-12 p-md-1"></div>
      <div class="p-col-12 p-md-10">
        <div class="p-grid p-jc-end" v-if="editable">
          <div class="p-col-10 p-md-8" style="justify-content:end">
            <div class="p-d-flex p-jc-end">
              <role-remove-dialog
                :roles="selectedRolesValue"
                @remove-role="removeRoleHandler"
              />
              <Button
                class="p-button-success p-mr-2"
                label="download"
                icon="pi pi-file"
                @click="downloadFileHandler"
              />
              <role-create-dialog @create-role="createRoleHandler" />
            </div>
          </div>
        </div>
        <div class="p-grid">
          <div class="p-col-12">
            <roles-table v-model:selectRoles="selectedRolesValue" />
          </div>
        </div>
      </div>
      <div class="p-col-12 p-md-1"></div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, Ref, computed, provide, inject } from 'vue'
import Button from 'primevue/button'
import RoleCreateDialog from '@/components/modules/roles/RoleCreateDialog.vue'
import RoleRemoveDialog from '@/components/modules/roles/RoleRemoveDialog.vue'
import RolesTable from '@/components/modules/roles/RolesTable.vue'
import {
  // editableRole,
  MembersType,
  MembersStateKey
  // useState
} from '@/services/members'
import {
  editableRole,
  RolesType,
  RolesStateKey,
  useState
} from '@/services/roles'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { ToastType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

export default defineComponent({
  name: 'Roles',
  components: {
    Button,
    RoleCreateDialog,
    RoleRemoveDialog,
    RolesTable
  },
  setup() {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const selectedRoles = ref<RolesType[]>([])
    const rolesService = useState()
    provide(RolesStateKey, rolesService)

    // computed
    const editable = computed((): boolean =>
      authApp.checkAuthority(editableRole)
    )

    const rolesNameList = computed((): Pick<MembersType, 'id' | 'name'>[] =>
      rolesService.state.roles.map((role) => {
        return { id: role.id, name: role.name }
      })
    )

    const selectedRolesValue = computed({
      get: (): RolesType[] => selectedRoles.value,
      set: (value: RolesType[]) => {
        selectedRoles.value = value
      }
    })

    // created
    const created = async () => {
      inversionFlag(loadingFlag)

      const permissionsListData = await rolesService.getPermissionsList(
        authApp.getHeaderOptions()
      )
      const response = await rolesService.getRolesData(
        authApp.getHeaderOptions()
      )

      if (response.status !== 200 || permissionsListData.status !== 200) {
        toast.add(rolesService.getToastData())
      }
      inversionFlag(loadingFlag)
    }
    created()

    // methods
    /**
     * handling create role event
     * @param {boolean} event
     * @return {void}
     */
    const createRoleHandler = async (event: boolean) => {
      inversionFlag(loadingFlag)
      const response = await rolesService.getRolesData(
        authApp.getHeaderOptions()
      )
      if (response.status !== 200) {
        toast.add(rolesService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    /**
     * handling remove role event
     * @param {boolean} event
     * @return {void}
     */
    const removeRoleHandler = async (event: boolean) => {
      selectedRoles.value = []
      inversionFlag(loadingFlag)
      const response = await rolesService.getRolesData(
        authApp.getHeaderOptions()
      )
      if (response.status !== 200) {
        toast.add(rolesService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    /**
     * handling download role event
     * @param {boolean} event
     * @return {void}
     */
    const downloadFileHandler = async () => {
      inversionFlag(loadingFlag)
      const response = await rolesService.downloadMemberCSV(
        authApp.getHeaderOptions()
      )
      if (response.status !== 304) {
        toast.add(rolesService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    return {
      rolesNameList,
      editable,
      selectedRolesValue,
      createRoleHandler,
      removeRoleHandler,
      downloadFileHandler
    }
  }
})
</script>
