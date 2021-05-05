<template>
  <div class="app-file-input">
    <div
      class="app-file-input__drop-area"
      :class="{ 'app-file-input__drag_on': isDragedState }"
      @dragover.prevent="onArea"
      @drop.prevent="dropFile"
      @dragleave.prevent="offArea"
      @dragend.prevent="offArea"
    >
      <template v-if="value">
        <div class="app-file-input__selected-file">
          <span class="app-file-input__file-name" v-show="value">
            {{ value.name }}
            <span class="app-file-input__reset-file-icon" @click="resetFile">×</span>
          </span>
        </div>
      </template>
      <template v-else>
        <label
          >ファイルを選択
          <input
            ref="fileRef"
            type="file"
            :accept="accept"
            @input="inputEventHandler"
          />
        </label>
      </template>
    </div>
    <p class="app-file-input__error-text" v-show="isInputError">
      {{ errorTextValue }}
    </p>
    <template v-if="enablePreview">
      <img :src="imageDataValue" alt="" />
    </template>
  </div>
</template>

<script lang="ts">
import {
  defineComponent,
  onMounted,
  ref,
  Ref,
  PropType,
  reactive,
  SetupContext,
  computed
} from 'vue'

type Props = {
  value: undefined | File
  accept: string
  enablePreview: boolean
  size: number
}

interface HTMLElementEvent<T extends HTMLElement> extends Event {
  target: T
}

export default defineComponent({
  name: 'AppFileInput',
  props: {
    value: {
      type: File,
      default: undefined
    },
    accept: {
      type: String,
      default: 'image/png,image/jpeg,image/gif'
    },
    enablePreview: {
      type: Boolean,
      default: false
    },
    size: {
      type: Number,
      default: 1
    }
  },
  setup(props: Props, context: SetupContext) {
    const imageData = ref<string | ArrayBuffer | null>('')
    const fileRef = ref<HTMLInputElement>()
    const errorText = ref<string>('')
    const isError = ref<boolean>(false)
    const isDraged = ref<boolean>(false)

    // computed
    const inputValue = computed((): undefined | File => props.value)
    /* const inputValue = computed({
      get: (): undefined | File => props.value,
      set: (value: undefined | File) => {
        context.emit('update:value', value)

        if (props.enablePreview && value) {
          createImage(value)
        }
      }
    }) */

    const imageDataValue = computed(
      (): string | ArrayBuffer | null => imageData.value
    )

    const errorTextValue = computed((): string => errorText.value)

    const isInputError = computed((): boolean => isError.value)

    const isDragedState = computed((): boolean => isDraged.value)

    // mounted
    onMounted(() => {
      // the DOM element will be assigned to the ref after initial render
      /* console.log('mount1: ' + JSON.stringify(fileRef.value)) // <div>This is a root element</div>
      console.log('mount2: ' + JSON.stringify(fileRef.value?.files))
      console.log('mount3: ' + JSON.stringify(fileRef.value?.click()))
      console.log('mount4: ' + JSON.stringify(fileRef.value?.value)) */
    })

    // methods
    /**
     * create preview image
     * @param {File} file
     * @return {void}
     */
    const createImage = (file: File) => {
      const reader = new FileReader()
      reader.onload = (e: ProgressEvent) => {
        // imageData.value = e.target.result
        imageData.value = reader.result
      }
      reader.readAsDataURL(file)
    }

    /**
     * input event handler
     * @param {Event} event
     * @return {void}
     */
    const inputEventHandler = (event: HTMLElementEvent<HTMLInputElement>) => {
      const data = event.target.files ? event.target.files![0] : undefined
      context.emit('update:value', data)

      if (props.enablePreview && event) {
        createImage(event.target.files![0])
      }
    }

    /**
     * reset input file
     * @param {Event} event
     * @return {void}
     */
    const resetFile = (event: Event) => {
      context.emit('reset-file', event)
      isError.value = false
      errorText.value = ''
    }

    /**
     * reset input file
     * event.targetの型を予め指定しておく(event.target as HTMLElement)
     * @param {HTMLElementEvent<HTMLInputElement>} event
     * @return {void}
     */
    const changeFile = (
      event: HTMLElementEvent<HTMLInputElement> /* e: Event */
    ) => {
      const files = event.target.files

      /* if (this.validation(files[0])) {
          this.file = files[0]

          console.log(this.file.name)

          // dataURL化
          this.fileEncode(this.file)
              .then(decodeData => {
                  return console.log(decodeData)
              })
              .catch(_ => { return console.log("FileUpload Error") })
      } else {
          this.file = {}
      } */
    }

    const changeFileDrag = (event: DragEvent) => {
      const files = event.dataTransfer?.files

      // const data = event.target.files ? event.target.files![0] : undefined
      context.emit('update:value', event.dataTransfer?.files[0])
    }

    const onArea = () => {
      isDraged.value = true
    }
    const offArea = () => {
      isDraged.value = false
    }

    const dropFile = (event: DragEvent) => {
      changeFileDrag(event as DragEvent)
      offArea()
    }

    return {
      inputValue,
      imageDataValue,
      errorTextValue,
      isInputError,
      isDragedState,
      fileRef,
      inputEventHandler,
      resetFile,
      dropFile,
      onArea,
      offArea,
      createImage
    }
  }
})
</script>
<style lang="scss">
.app-file-input {
  label {
    font-size: 12px;
    padding: 2px 3px;
  }

  label:hover {
    cursor: pointer;
  }

  label input {
    display: none;
  }

  &__file-name {
    font-size: 14px;
    margin-left: 20px;
  }

  &__reset-file-icon {
    color: #ff0000;
    padding: 0 4px;
    font-size: 12px;
    border: 1px solid #c6c6c6;
    border-radius: 10px;

    &:hover {
      cursor: pointer;
      border-color: #5f6674;
    }
  }

  &__selected-file {
    font-size: 12px;
    padding: 2px 3px;
    word-break: break-all;
  }

  /* .reset-file-icon:hover {
    cursor: pointer;
    border-color: #5f6674;
  } */

  &__error-text {
    color: #d70035;
  }

  &__drop-area {
    width: 200px;
    padding: 10px;
    text-align: center;
    border: 1px dashed #c6c6c6;
    background-color: #f9f9f9;
  }

  &__drag_on {
    border: 2px dashed #bcbcbc;
    background-color: #fafdff;
  }
}
</style>
