import { shallowMount } from '@vue/test-utils'
import CircleLoading from '@/components/parts/CircleLoading.vue'

describe('CircleLoading.vue', () => {
  it('check props value', () => {
    const open = true
    const wrapper = shallowMount(CircleLoading, {
      props: { open }
    })

    expect(wrapper.props().open).toBe(true)
  })

  it('check display none', () => {
    const open = false
    const wrapper = shallowMount(CircleLoading, {
      props: { open }
    })

    const regex = 'style="display: none;"'
    expect(wrapper.html()).toContain(regex)
  })
})
