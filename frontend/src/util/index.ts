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
 * make binary data object url.
 * [0xef, 0xbb, 0xbf]はbyte order mark(BOM)。Unicodeで符号化したテキストの先頭に付与される数バイトのデータ。
 * 8ビット符号なし整数値を表現可能なUint8Array()メソッドでバイナリデータとしてセットする事で文字コードをBOM付きのUTF-8と指定する。
 * @param {string} data
 * @param {string} mimeType - default 'text/csv'
 * @return {string}
 */
export const makeDataUrl = (data: string, mimeType = 'text/csv'): string => {
  if (!(mimeType === 'text/csv' || mimeType === 'application/csv')) {
    return (window.URL || window.webkitURL).createObjectURL(new Blob([data]))
  } else {
    const bom = new Uint8Array([0xef, 0xbb, 0xbf])
    // バイナリデータを表すBlobオブジェクトに設定したいデータとmimetypeを指定する
    const blob = new Blob([bom, data], { type: mimeType })
    return (window.URL || window.webkitURL).createObjectURL(blob)
  }
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
