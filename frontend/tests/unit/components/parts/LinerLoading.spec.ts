import { shallowMount, VueWrapper } from '@vue/test-utils'
import LinerLoading from '@/components/parts/LinerLoading.vue'

const open = true

describe('LinerLoading.vue', () => {
  let wrapper: VueWrapper<any>

  beforeEach(() => {
    wrapper = shallowMount(LinerLoading, {
      props: { open }
    })
  })

  it('check props value', () => {
    expect(wrapper.props().open).toBe(true)
  })

  it('check display none', async () => {
    await wrapper.setProps({ open: false })

    const regex = 'style="display: none;"'
    expect(wrapper.html()).toContain(regex)
  })
})
