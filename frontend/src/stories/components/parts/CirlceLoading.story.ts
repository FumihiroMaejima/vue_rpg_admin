/* eslint-disable @typescript-eslint/no-var-requires */
// import { action } from '@storybook/addon-actions'
import { boolean } from '@storybook/addon-knobs'
import CircleLoading from '../../../components/parts/CircleLoading.vue'
const textData = require('../../notes/sample.md')
const markdown = textData.default

// コンポーネントのメタデータを記述
export default {
  title: 'Test/CircleLoadingTest',
  parameters: {
    layout: 'centered',
    docs: {
      extractComponentDescription: (component: any, { notes }: any) => {
        if (notes) {
          return notes.markdown
        }
        return null
      }
    },
    notes: { markdown }
  }
}

export const CircleLoadingTest = () => ({
  components: { CircleLoading },
  template: `
    <div>
      <CircleLoading :open="open" />
    </div>
  `,
  props: {
    open: {
      type: Boolean,
      default: boolean('open', true)
    }
  },
  data() {
    return {}
  },
  methods: {}
})
