/* eslint-disable @typescript-eslint/no-var-requires */
// import { action } from '@storybook/addon-actions'
import { text } from "@storybook/addon-knobs";
import HelloWorld from "../components/HelloWorld.vue";
const textData = require('./notes/sample.md')
const markdown = textData.default

// コンポーネントのメタデータを記述
export default {
  title: "Test/HelloTest",
  parameters: {
    layout: "centered",
    docs: {
      extractComponentDescription: (component: any, { notes }: any) => {
        if (notes) {
          return notes.markdown;
        }
        return null;
      }
    },
    notes: { markdown }
  }
};

export const HelloTest = () => ({
  components: { HelloWorld },
  template: `
    <div>
      <HelloWorld :msg="msg" />
    </div>
  `,
  props: {
    msg: {
      type: String,
      default: text("msg", "default text")
    }
  },
  data() {
    return {};
  },
  methods: {}
});
