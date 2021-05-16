import {
  inversionFlag,
  getMultiSelectLabel,
  // makeDataUrl,
  // downloadFile,
  InvalidStateErrorUtil
} from '@/util'
import { ref } from 'vue'

const testFlagData = ref<boolean>(false)

const testSelectBoxData = [
  { text: 'test1', value: 1 },
  { text: 'test2', value: 2 },
  { text: 'test3', value: 3 }
]

describe('Utility File Check', () => {
  it('check inversionFlag', () => {
    inversionFlag(testFlagData)
    expect(testFlagData.value).toBe(true)
    inversionFlag(testFlagData)
    expect(testFlagData.value).toBe(false)
  })

  it('check getMultiSelectLabel', () => {
    const testParam = [testSelectBoxData[0].value, testSelectBoxData[1].value]
    const expectValue = [testSelectBoxData[0].text, testSelectBoxData[1].text]

    expect(getMultiSelectLabel(testParam, testSelectBoxData)).toStrictEqual(
      expectValue
    )
  })

  it('check InvalidStateErrorUtil class', () => {
    const testData = 'invalid string Data.'
    const message = `catch invalid value ${testData}`
    const instance = new InvalidStateErrorUtil(testData as never, message)

    expect(instance.message).toStrictEqual(message)
    expect(instance.name).toStrictEqual('Error')
  })
})
