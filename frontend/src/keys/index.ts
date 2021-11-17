import { InjectionKey, Ref } from 'vue'
import { ToastType } from '@/types/applications/index'
import AuthApp from '@/plugins/auth/authApp'

export const AuthAppKey: InjectionKey<AuthApp> = Symbol('authApp')

export const ToastTypeKey: InjectionKey<ToastType> = Symbol('ToastType')

export const CircleLoadingKey: InjectionKey<Ref<boolean>> = Symbol(
  'circleLoading'
)
export const LinerLoadingKey: InjectionKey<Ref<boolean>> = Symbol(
  'linerLoading'
)
