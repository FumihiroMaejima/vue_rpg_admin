/**
 * check text length exclude space.
 * @param {string} value
 * @return {boolean}
 */
export function checkTextLength(value: string): boolean {
  // null or undefined
  if (!value) {
    return false
  }
  // string length check
  return value.trim().length > 0
}

/**
 * check text max length.
 * @param {string} value
 * @param {null | number} maxlength
 * @return {boolean}
 */
export function checkTextMaxLength(
  value: string,
  maxlength: null | number = null
): boolean {
  if (value === null) {
    return true
  }
  return value.length <= maxlength!
}

/**
 * check text min length.
 * @param {string} value
 * @param {number} minlength
 * @return {boolean}
 */
export function checkTextMinLength(value: string, maxlength = 0): boolean {
  return value.length >= maxlength!
}

/**
 * check value type.
 * @param {string | number | Object = Record<string, any>} value
 * @param {string} target
 * @return {boolean}
 */
export function checkPrimitiveType(
  value: string | number | string[] | number[] | Record<string, any>,
  target = 'string'
): boolean {
  return typeof value === target
}

/**
 * check text white space.
 * @param {string} value
 * @param {string} comparedValue
 * @return {boolean}
 */
export function checkTextEquals(value: string, comparedValue: string): boolean {
  return value === comparedValue
}

/**
 * check text white space.
 * @param {string} value
 * @return {boolean}
 */
export function checkEmailRegex(value: string): boolean {
  const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  // const regexp = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/
  // 小文字に変換
  return regex.test(String(value).toLowerCase())
}

/**
 * check text white space.
 * @param {string} value
 * @return {boolean}
 */
export function checkPasswordRegex(value: string): boolean {
  // 半角英数字8-100文字の正規表現
  const regex = /^(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}$/i
  return regex.test(String(value).toLowerCase())
}

/**
 * check file size(byte size).
 * @param {number} targetSize
 * @param {number} maxFileSize
 * @return {boolean}
 */
export function checkFileSize(
  targetSize: number,
  maxFileSize: number
): boolean {
  return targetSize <= maxFileSize
}

/**
 * check file type.
 * @param {string} targetAccept
 * @param {string | string[]} accept
 * @return {boolean}
 */
export function checkFileType(
  targetAccept: string,
  accept: string | string[]
): boolean {
  if (typeof accept === 'string') {
    return targetAccept === accept
  } else {
    return accept.includes(targetAccept)
  }
}

/**
 * check file length.
 * @param {number} targetLength
 * @param {number} maxFileLength
 * @return {boolean}
 */
export function checkFileLength(
  targetLength: number,
  maxFileLength: number
): boolean {
  return targetLength <= maxFileLength
}

/**
 * check text white space.
 * @param {string} value
 * @return {string} message
 */
export function validateName(value: string): string {
  let message = ''
  const size = 5
  if (!checkTextLength(value)) {
    return (message = 'This is required')
  } else if (!checkTextMinLength(value, size)) {
    return (message = `input over ${size} length text`)
  }
  return message
}

/**
 * check text white space.
 * @param {string} value
 * @return {string} message
 */
export function validateEmail(value: string): string {
  let message = ''
  const size = 5
  if (!checkTextLength(value)) {
    return (message = 'This is required')
  } else if (!checkTextMinLength(value, size)) {
    return (message = `input over ${size} length text`)
  } else if (!checkEmailRegex(value)) {
    return (message = 'invalidate text')
  }
  return message
}

/**
 * check text white space.
 * @param {string} value
 * @return {string} message
 */
export function validateSelectBoxNumberValue(value: number): string {
  let message = ''
  if (!checkPrimitiveType(value, 'number')) {
    return (message = 'invalid type')
  }
  return message
}

/**
 * check text white space.
 * @param {string} value
 * @return {string} message
 */
export function validatePassword(value: string): string {
  let message = ''
  const size = 8
  if (!checkTextLength(value)) {
    return (message = 'This is required')
  } else if (!checkTextMinLength(value, size)) {
    return (message = `input over ${size} length text`)
  } else if (!checkPasswordRegex(value)) {
    return (message = 'invalidate text')
  }
  return message
}

/**
 * check text white space.
 * @param {string} value
 * @return {string} message
 */
export function validateConfirmPassword(
  value: string,
  comparedValue: string
): string {
  let message = ''
  if (!checkTextLength(value)) {
    return (message = 'This is required')
  } else if (!checkTextEquals(value, comparedValue)) {
    return (message = 'please input same value')
  }
  return message
}

/**
 * validate role code.
 * @param {string} value
 * @return {string} message
 */
export function validateRoleCode(value: string): string {
  let message = ''
  const size = 5
  if (!checkTextLength(value)) {
    return (message = 'This is required')
  } else if (!checkTextMinLength(value, size)) {
    return (message = `input over ${size} length text`)
  }
  return message
}

/**
 * validate role deetail.
 * @param {string} value
 * @return {string} message
 */
export function validateRoleDetail(value: string): string {
  let message = ''
  const size = 5
  if (!checkTextLength(value)) {
    return (message = 'This is required')
  } else if (!checkTextMinLength(value, size)) {
    return (message = `input over ${size} length text`)
  }
  return message
}

/**
 * check text white space.
 * @param {string} value
 * @return {string} message
 */
export function validateMultipleNumberValue(value: number[]): string {
  let message = ''
  if (!checkPrimitiveType(value, 'object')) {
    return (message = 'invalid type')
  } else if (value.length === 0) {
    return (message = `select at least one permission`)
  }
  return message
}
