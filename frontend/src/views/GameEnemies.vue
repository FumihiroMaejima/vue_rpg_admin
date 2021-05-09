<template>
  <div class="cp-fluid p-mx-md-6 p-mx-sm-2 p-mb-6">
    <h1 class="italic my-2">管理サービス-敵キャラクター情報</h1>
    <h2 class="italic my-2">敵キャラクター一覧</h2>
    <div class="p-grid">
      <div class="p-col-12 p-md-1"></div>
      <div class="p-col-12 p-md-12">
        <div class="p-grid p-jc-end" v-if="editable">
          <div class="p-col-10 p-md-8" style="justify-content:end">
            <div class="p-d-flex p-jc-end">
              <!-- <role-remove-dialog
                :roles="selectedEnemiesValue"
                @remove-role="removeRoleHandler"
              /> -->

              <Button
                class="p-button-success"
                label="download"
                icon="pi pi-file"
                @click="downloadFileHandler"
              />
              <enemies-import-dialog @import-enemies="importEnemiesHandler"/>
              <!-- <role-create-dialog @create-role="createRoleHandler" /> -->
            </div>
          </div>
        </div>
        <div class="p-grid">
          <div class="p-col-12">
            <game-enemies-table v-model:selectEnemies="selectedEnemiesValue" />
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
import GameEnemiesTable from '@/components/modules/game/enemies/GameEnemiesTable.vue'
import EnemiesImportDialog from '@/components/modules/game/enemies/EnemiesImportDialog.vue'
import {
  // editableRole,
  RolesType,
  RolesStateKey
  // useState
} from '@/services/roles'
import {
  editableRole,
  EnemyType,
  EnemiesStateKey,
  useState
} from '@/services/game/enemies'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { ToastType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

export default defineComponent({
  name: 'GameEnemies',
  components: {
    Button,
    // RoleCreateDialog,
    // RoleRemoveDialog,
    EnemiesImportDialog,
    GameEnemiesTable
    // RolesTable
  },
  setup() {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const selectedEnemies = ref<EnemyType[]>([])
    const gameEnemiesService = useState()
    provide(EnemiesStateKey, gameEnemiesService)

    // computed
    const editable = computed((): boolean =>
      authApp.checkAuthority(editableRole)
    )

    const selectedEnemiesValue = computed({
      get: (): EnemyType[] => selectedEnemies.value,
      set: (value: EnemyType[]) => {
        selectedEnemies.value = value
      }
    })

    // created
    const created = async () => {
      inversionFlag(loadingFlag)

      const response = await gameEnemiesService.getEnemiesRequest(
        authApp.getHeaderOptions()
      )

      if (response.status !== 200) {
        toast.add(gameEnemiesService.getToastData())
      }
      inversionFlag(loadingFlag)
    }
    created()

    // methods
    /**
     * handling import enevemies event
     * @param {boolean} event
     * @return {void}
     */
    const importEnemiesHandler = async (event: boolean) => {
      inversionFlag(loadingFlag)
      const response = await gameEnemiesService.getEnemiesRequest(
        authApp.getHeaderOptions()
      )
      if (response.status !== 200) {
        toast.add(gameEnemiesService.getToastData())
      }
      inversionFlag(loadingFlag)
    }
    /**
     * handling download enemies event
     * @param {boolean} event
     * @return {void}
     */
    const downloadFileHandler = async () => {
      inversionFlag(loadingFlag)
      const response = await gameEnemiesService.downloadEnemiesCSVRequest(
        authApp.getHeaderOptions()
      )
      if (response.status !== 304) {
        toast.add(gameEnemiesService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    return {
      editable,
      selectedEnemiesValue,
      importEnemiesHandler,
      downloadFileHandler
    }
  }
})
</script>
