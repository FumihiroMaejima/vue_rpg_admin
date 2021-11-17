<template>
  <Button
    class="p-button-danger p-mr-2"
    label="Remove"
    icon="pi pi-user"
    @click="display = true"
  />
  <Dialog
    class="role-remove-dialog"
    header="Role Remove Modal"
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
              class="p-col-fixed role-remove-dialog__form-label"
            >
              roles
            </label>
          </div>
          <div class="p-col-12 p-md-10">
            <div class="p-col">
              <div>
                <template v-if="rolesNameList.length === 0">
                  <div>
                    no roles selected.
                  </div>
                </template>
                <template v-else>
                  <span
                    class="role-remove-dialog__chip"
                    v-for="(item, i) of rolesNameList"
                    :key="i"
                  >
                    {{ item }}
                  </span>
                </template>
              </div>
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
            @click="removeRoleHandler"
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
  computed,
  SetupContext,
  inject
} from 'vue'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'

import { RolesType, RolesStateKey, RolesStateType } from '@/services/roles'
import AuthApp from '@/plugins/auth/authApp'
import { inversionFlag } from '@/util'
// import { useField, useForm } from 'vee-validate'
import { ToastType } from '@/types/applications/index'
import { AuthAppKey, ToastTypeKey, CircleLoadingKey } from '@/keys'

type Props = {
  roles: RolesType[]
}

export default defineComponent({
  name: 'RoleRemoveDialog',
  components: {
    Button,
    Dialog /* ,
    Dropdown */
  },
  props: {
    roles: {
      type: Array as PropType<RolesType[]>,
      required: false,
      default: () => {
        return []
      }
    }
  },
  setup(props: Props, context: SetupContext) {
    const toast = inject(ToastTypeKey) as ToastType
    const loadingFlag = inject(CircleLoadingKey) as Ref<boolean>
    const authApp = inject(AuthAppKey) as AuthApp
    const rolesService = inject(RolesStateKey) as RolesStateType
    const display = ref<boolean>(false)

    // computed
    const rolesNameList = computed((): string[] =>
      props.roles.map((role) => role.name)
    )

    const removeDisabled = computed((): boolean => {
      return !(props.roles.length !== 0)
    })

    // created
    /* const created = async () => {}
    created() */

    // methods
    /**
     * catch remove role event
     * @return {void}
     */
    const removeRoleHandler = async () => {
      display.value = false
      // サーバーへリクエスト
      inversionFlag(loadingFlag)
      const response = await rolesService.removeRoleRequest(
        props.roles.map((role) => role.id),
        authApp.getHeaderOptions()
      )
      toast.add(rolesService.getToastData())
      if (response.status === 200) {
        // formContext.handleReset()
        context.emit('remove-role', true)
      }
      inversionFlag(loadingFlag)
    }

    return {
      display,
      rolesNameList,
      removeDisabled,
      removeRoleHandler
    }
  }
})
</script>
<style lang="scss">
.role-remove-dialog {
  width: 45vw;

  &__form-label {
    width: 100%;
  }

  &__form-dropdown {
    width: 100%;
  }

  .role-remove-dialog__form-dropdown.p-dropdown {
    padding: 0 0 0 0 !important;
  }

  &__form-input {
    width: 100%;
    input {
      width: 100%;
    }
  }

  &__chip {
    display: inline-flex;
    margin: 2px 2px;
    padding: 0 4px;
    flex-direction: row;
    background-color: #e5e5e5;
    cursor: default;
    height: 30px;
    font-size: 14px;
    color: #333333;
    font-family: 'Open Sans', sans-serif;
    white-space: nowrap;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
  }
}
</style>
