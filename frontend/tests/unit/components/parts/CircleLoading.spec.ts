import { shallowMount, VueWrapper } from '@vue/test-utils'
import CircleLoading from '@/components/parts/CircleLoading.vue'

const open = true

describe('CircleLoading.vue', () => {
  let wrapper: VueWrapper<any>

  beforeEach(() => {
    wrapper = shallowMount(CircleLoading, {
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
