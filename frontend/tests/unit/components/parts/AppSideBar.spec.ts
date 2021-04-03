import { shallowMount, VueWrapper } from '@vue/test-utils'
import AppSideBar from '@/components/parts/AppSideBar.vue'
import { localGlobalOptions } from '../../localVue'

const value = true

describe('AppSideBar.vue', () => {
  let wrapper: VueWrapper<any>

  beforeEach(() => {
    wrapper = shallowMount(AppSideBar, {
      props: { value },
      global: localGlobalOptions()
    })
  })

  it('check props value true', () => {
    /* const childComponent = 'sidebar'
    wrapper.getComponent(`${childComponent}-stub`) */

    expect(wrapper.props().value).toBe(value)
  })

  it('check props value false', async () => {
    await wrapper.setProps({ value: false })
    expect(wrapper.props('value')).toBe(false)
  })
})
