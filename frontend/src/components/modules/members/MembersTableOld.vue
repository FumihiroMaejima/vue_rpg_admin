<template>
  <div>
    <app-table
      :items="members"
      :columnOptions="columnOptions"
      :editable="editable"
      @update-text="updateTextValue"
      @blur-text="catchBlurEventHandler"
      @update-select="updateSelectValue"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent, Ref, reactive, computed, watch, inject } from 'vue'
import AppTable from '@/components/parts/AppTable.vue'
import {
  editableRole,
  tableSetting,
  MembersType,
  MembersTextKeys,
  MembersSelectKeys,
  MembersStateKey,
  MembersStateType
} from '@/services/members'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { ToastType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

export default defineComponent({
  name: 'MembersTableOld',
  components: {
    AppTable
  },
  setup() {
    const toast = inject(ToastTypeKey) as ToastType
    const columnOptions = reactive(tableSetting)
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const membersService = inject(MembersStateKey) as MembersStateType

    // computed
    const members = computed((): MembersType[] => membersService.state.members)
    const editable = computed((): boolean =>
      authApp.checkAuthority(editableRole)
    )

    // created
    /* const created = async () => {}
    created() */

    // watch
    watch(
      () => membersService.state.roles,
      (newValue /* , old */) => {
        if (columnOptions[3].type === 'select') {
          columnOptions[3].items = [...newValue]
        }
        /* ... */
      }
    )

    // methods
    /**
     * catch update text event
     * @param {{id: number, key: string, value: string}}
     * @return {void}
     */
    const updateTextValue = (event: {
      id: number
      key: string
      value: string
    }) => {
      membersService.updateStateTextValue(
        event.id,
        event.key as MembersTextKeys,
        event.value
      )
    }

    /**
     * catch update text event
     * @param {{id: number, key: string, value: string}}
     * @return {void}
     */
    const catchBlurEventHandler = async (event: {
      id: number
      key: string
      value: boolean
    }) => {
      inversionFlag(loadingFlag)
      const response = await membersService.updateMembersDataRequest(
        event.id,
        authApp.getHeaderOptions()
      )

      if (response.status !== 304) {
        toast.add(membersService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    /**
     * catch update select event
     * @param {{id: number, key: string, value: number}}
     * @return {void}
     */
    const updateSelectValue = async (event: {
      id: number
      key: string
      value: number
    }) => {
      membersService.updateStateSelectValue(
        event.id,
        event.key as MembersSelectKeys,
        event.value
      )

      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      const response = await membersService.updateMembersDataRequest(
        event.id,
        authApp.getHeaderOptions()
      )

      if (response.status !== 304) {
        toast.add(membersService.getToastData())
      }
      inversionFlag(loadingFlag)
    }

    return {
      members,
      editable,
      updateTextValue,
      catchBlurEventHandler,
      updateSelectValue,
      columnOptions
    }
  }
})
</script>
