/**
 * check text white space.
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
