import { shallowMount } from '@vue/test-utils'
import AppIcon from '@/components/parts/AppIcon.vue'

describe('AppIcon.vue', () => {
  it('check props value', () => {
    const name = 'test name'
    const size = 3
    const wrapper = shallowMount(AppIcon, {
      props: { name, size }
    })

    expect(wrapper.props().name).toBe(name)
  })
})
