<template>
  <Button
    class="p-button-danger p-mr-2"
    label="Remove"
    icon="pi pi-user"
    @click="display = true"
  />
  <Dialog
    class="member-remove-dialog"
    header="Member Remove Modal"
    v-model:visible="display"
    :modal="true"
    :breakpoints="{ '960px': '90vw' }"
  >
    <div class="p-grid p-nogutter p-jc-center">
      <div class="p-col-12">
        <div
          class="p-grid p-nogutter p-jc-center p-ai-center vertical-container"
        >
          <div class="p-col-12 p-md-2">
            <label
              for="role"
              class="p-col-fixed member-remove-dialog__form-label"
            >
              member
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <Dropdown
                  class="p-col-fixed member-remove-dialog__form-dropdown"
                  v-model="memberValue"
                  :options="members"
                  optionLabel="name"
                  optionValue="id"
                  placeholder="select role"
                  filter
                />
              </div>
              <small class="p-error">{{ memberError }}</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="p-grid p-jc-end">
      <div class="p-col-6 p-md-4" style="justify-content:end">
        <div class="p-d-flex p-jc-end">
          <Button
            class="p-button-danger p-button-raised"
            icon="pi pi-send"
            label="remove"
            :disabled="removeDisabled"
            @click="removeMemberHandler"
          />
        </div>
      </div>
    </div>
  </Dialog>
</template>

<script lang="ts">
/* eslint-disable @typescript-eslint/camelcase */
import {
  defineComponent,
  ref,
  Ref,
  PropType,
  reactive,
  computed,
  SetupContext,
  watch,
  inject
} from 'vue'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import Dropdown from 'primevue/dropdown'

import {
  formSchema,
  removeFormSchema,
  editableRole,
  tableSetting,
  MembersType,
  MembersTextKeys,
  MembersSelectKeys,
  MembersStateKey,
  MembersStateType,
  useState
} from '@/services/members'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
import { useField, useForm } from 'vee-validate'
import { checkTextLength } from '@/util/validation'
import { ToastType, SelectBoxType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

type Props = {
  members: Pick<MembersType, 'id' | 'name'>[]
}

export default defineComponent({
  name: 'MemberRemoveDialog',
  components: {
    Button,
    Dialog,
    // InputText,
    Dropdown
  },
  props: {
    members: {
      type: Array as PropType<Pick<MembersType, 'id' | 'name'>[]>,
      required: false,
      default: []
    }
  },
  setup(__, context: SetupContext) {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const membersService = inject(MembersStateKey) as MembersStateType
    const display = ref<boolean>(false)
    const rolesList = reactive<SelectBoxType[]>([])

    const formContext = useForm({
      validationSchema: removeFormSchema
    })

    const { value: member, errorMessage: memberError } = useField<number>(
      'member'
    )

    // watch
    watch(
      () => membersService.state.roles,
      (newValue, old) => {
        newValue.forEach((role) => rolesList.push(role))
      }
    )

    // computed
    const memberValue = computed({
      get: (): number => member.value,
      set: (value: number) => {
        member.value = value
      }
    })

    const removeDisabled = computed((): boolean => {
      return !(memberError.value === '')
    })

    // created
    /* const created = async () => {}
    created() */

    // methods
    /**
     * catch create member event
     * @return {void}
     */
    const removeMemberHandler = async () => {
      display.value = false
      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      const response = await membersService.removeMember(
        member.value,
        authApp.getHeaderOptions()
      )
      toast.add(membersService.getToastData())
      if (response.status === 200) {
        formContext.handleReset()
        context.emit('remove-member', true)
      }
      inversionFlag(loadingFlag)
    }

    return {
      display,
      rolesList,
      memberValue,
      memberError,
      removeDisabled,
      removeMemberHandler
    }
  }
})
</script>
<style lang="scss">
.member-remove-dialog {
  width: 45vw;

  &__form-label {
    width: 100%;
  }

  &__form-dropdown {
    width: 100%;
  }

  .member-remove-dialog__form-dropdown.p-dropdown {
    padding: 0 0 0 0 !important;
  }

  &__form-input {
    width: 100%;
    input {
      width: 100%;
    }
  }
}
</style>
