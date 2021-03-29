import { shallowMount } from '@vue/test-utils'
import LinerLoading from '@/components/parts/LinerLoading.vue'

describe('LinerLoading.vue', () => {
  it('check props value', () => {
    const open = true
    const wrapper = shallowMount(LinerLoading, {
      props: { open }
    })

    expect(wrapper.props().open).toBe(true)
  })

  it('check display none', () => {
    const open = false
    const wrapper = shallowMount(LinerLoading, {
      props: { open }
    })

    const regex = 'style="display: none;"'
    expect(wrapper.html()).toContain(regex)
  })
})
