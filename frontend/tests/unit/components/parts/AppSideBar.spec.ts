import { shallowMount } from '@vue/test-utils'
import AppSideBar from '@/components/parts/AppSideBar.vue'
import { localGlobalOptions } from '../../localVue'

describe('AppSideBar.vue', () => {
  it('check props value', () => {
    const value = true
    const wrapper = shallowMount(AppSideBar, {
      props: { value },
      global: localGlobalOptions()
    })

    expect(wrapper.props().value).toBe(value)
  })
})
