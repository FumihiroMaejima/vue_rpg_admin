/**
 * output console.log.
 * @param {any} value - string number object array etc...
 * @param {string} text - log title. defalut 'test'
 * @return {void}
 */
export function dd(value: any, text = 'test') {
  console.log(`${text}: ${JSON.stringify(value, null, 2)}`)
}
