import { InjectionKey, Ref } from 'vue'

import { ToastType } from '@/types/components/index'

export const ToastTypeKey: InjectionKey<ToastType> = Symbol('ToastType')

export const CircleLoadingKey: InjectionKey<Ref<boolean>> = Symbol(
  'circleLoading'
)
export const LinerLoadingKey: InjectionKey<Ref<boolean>> = Symbol(
  'linerLoading'
)
