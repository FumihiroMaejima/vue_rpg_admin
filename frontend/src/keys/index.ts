import { InjectionKey } from 'vue'

import { ToastType } from '@/types/components/index'

export const ToastTypeKey: InjectionKey<ToastType> = Symbol('ToastType')
