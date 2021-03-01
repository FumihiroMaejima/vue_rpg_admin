<template>
  <div>
    <app-table
      :items="members"
      :columnOptions="columnOptions"
      :editable="true"
    />
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
import AppTable from '@/components/parts/AppTable.vue'
import {
  tableSetting,
  MembersType,
  MembersStateKey,
  MembersStateType,
  useState
} from '@/services/members'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { ToastType } from '@/types/components/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

export default defineComponent({
  name: 'MembersTable',
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
    console.log(
      'membersService: ' + JSON.stringify(membersService.state.members, null, 2)
    )

    // created
    const created = async () => {
      /* inversionFlag(loadingFlag)
      const response = await membersService.getMembersData(authApp.getHeaderOptions())
      if (response.status !== 200) {
        toast.add(membersService.getToastData())
      } */
      /* console.log(
        'membersService.getMembersData(): ' +
          JSON.stringify(membersService.getMembersData(), null, 2)
      ) */
      // inversionFlag(loadingFlag)
    }
    created()

    // methods

    return {
      members,
      columnOptions
    }
  }
})
</script>