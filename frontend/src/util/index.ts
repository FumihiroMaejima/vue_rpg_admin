import { Ref } from 'vue'

/**
 * inversion boolean flag.
 * @param {Ref<boolean>} value
 * @return {void}
 */
export function inversionFlag(flag: Ref) {
  flag.value = !flag.value
}

/**
 * inversion boolean flag.
 * @param {string} data
 * @param {string} mimeType - default 'text/csv'
 * @return {string}
 */
export const makeDataUrl = (data: string, mimeType = 'text/csv'): string => {
  const bom = new Uint8Array([0xef, 0xbb, 0xbf])
  const blob = new Blob([bom, data], { type: mimeType })
  return (window.URL || window.webkitURL).createObjectURL(blob)
}

/**
 * download file.
 * @param {string} url
 * @param {string} name
 * @return {string}
 */
export const downloadFile = (url: string, name: string) => {
  const link = document.createElement('a')
  link.download = name
  link.href = url
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}

/**
 * inversion boolean flag.
 * @param {Ref<boolean>} value
 * @return {void}
 */
class InvalidStateErrorUtil extends Error {
  constructor(value: never, message?: string) {
    super(message)
  }
}
