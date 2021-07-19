import { Ref } from 'vue'
import { SelectBoxType } from '@/types'

/**
 * inversion boolean flag.
 * @param {Ref<boolean>} value
 * @return {void}
 */
export const inversionFlag = (flag: Ref) => {
  flag.value = !flag.value
}

/**
 * get selected item`s text.
 * @param {number[]} value
 * @param {SelectBoxType[]} items
 * @return {string[]}
 */
export const getMultiSelectLabel = (
  value: number[],
  items: SelectBoxType[]
) => {
  return items
    .filter((item) => value.includes(item.value))
    .map((item) => item.text)
}

/**
 * make binary data object url.
 * [0xef, 0xbb, 0xbf]はbyte order mark(BOM)。Unicodeで符号化したテキストの先頭に付与される数バイトのデータ。
 * 8ビット符号なし整数値を表現可能なUint8Array()メソッドでバイナリデータとしてセットする事で文字コードをBOM付きのUTF-8と指定する。
 * @param {string} data
 * @param {string} mimeType - default 'text/csv'
 * @return {string}
 */
export const makeDataUrl = (data: BlobPart, mimeType = 'text/csv'): string => {
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
 * get rounding random number value.(四捨五入)
 * @param {number} maxNumber
 * @return {number}
 */
export const getRoundingRandomInt = (maxNumber: number) => {
  return Math.round(Math.random() * maxNumber)
}

/**
 * get floor random value.(切り捨て)
 * @param {number} maxNumber
 * @return {number}
 */
export const getFloorRandomInt = (maxNumber: number) => {
  return Math.floor(Math.random() * maxNumber)
}

/**
 * ファイルの読み込みとデータをテキストとして取得
 * @param {File} file
 * @return {Promise<string | ArrayBuffer | null>}
 */
export const readFileDataAsText = async (
  file: File
): Promise<string | ArrayBuffer | null> => {
  return new Promise(
    (resolve: (param: string | ArrayBuffer | null) => void) => {
      const reader = new FileReader()
      reader.onload = (e: ProgressEvent) => {
        // 読み込んだ結果をresolve(解決)する
        resolve(reader.result)
      }
      // 読み込み
      reader.readAsText(file)
    }
  )
}

/**
 * 日付の形式(yyyy/mm/dd)のチェック
 * @param {string} value
 * @return {boolean}
 */
export const checkDateFormat = (value: string): boolean => {
  return value.match(/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}/u) !== null
}

/**
 * invalid type error class.
 * @param {Ref<boolean>} value
 * @return {void}
 */
export class InvalidStateErrorUtil extends Error {
  constructor(value: never, message?: string) {
    super(message)
  }
}
