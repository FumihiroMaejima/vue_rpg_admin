/* eslint-disable @typescript-eslint/no-var-requires */
// import { action } from '@storybook/addon-actions'
import { boolean } from '@storybook/addon-knobs'
import LinerLoading from '../../../components/parts/LinerLoading.vue'
const textData = require('../../notes/sample.md')
const markdown = textData.default

// コンポーネントのメタデータを記述
export default {
  title: 'Test/LinerLoadingTest',
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

export const LinerLoadingTest = () => ({
  components: { LinerLoading },
  template: `
    <div>
      <LinerLoading :open="open" />
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
