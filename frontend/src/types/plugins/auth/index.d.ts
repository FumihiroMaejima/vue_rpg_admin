export * from '@/types/plugins/auth/base'

export type AuthState = {
  name: string | null
  id: number | null
  authority: object | null
}
