import { shallowMount, VueWrapper } from '@vue/test-utils'
import AppFileInput from '@/components/parts/AppFileInput.vue'
import { localGlobalOptions } from '../../localVue'

const formLabel = 'ファイルを選択'
const value = new File(['test blob data'], 'file_name')
const accept = 'image/*'
const enablePreview = true
const fileSize = 2000000
const fileLength = 2

describe('AppFileInput.vue Check props', () => {
  it('check props value', () => {
    const wrapper = shallowMount(AppFileInput, {
      props: { formLabel, value, accept, enablePreview, fileSize, fileLength }
    })

    expect(wrapper.props().formLabel).toBe(formLabel)
    expect(wrapper.props().value).toBe(value)
    expect(wrapper.props().accept).toBe(accept)
    expect(wrapper.props().enablePreview).toBe(enablePreview)
    expect(wrapper.props().fileSize).toBe(fileSize)
    expect(wrapper.props().fileLength).toBe(fileLength)
  })
})
