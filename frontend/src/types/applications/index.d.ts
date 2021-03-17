/* eslint-disable @typescript-eslint/no-empty-interface */

export type ToastType = {
  add(args: ToastData): void
}

export type ToastData = {
  severity?: string
  summary?: string
  detail?: string
  life?: number
  closable?: boolean
  group?: string
}

export type SelectBoxType = {
  text: string
  value: number
}
