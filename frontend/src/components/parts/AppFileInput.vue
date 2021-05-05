<template>
  <div class="app-file-input">
    <div
      class="app-file-input__drop-area"
      :class="{ 'app-file-input__drag_on': isDragedState }"
      @dragover.prevent="changeDragedState(true)"
      @drop.prevent="dropFile"
      @dragleave.prevent="changeDragedState(false)"
      @dragend.prevent="changeDragedState(false)"
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
  ref,
  Ref,
  PropType,
  reactive,
  SetupContext,
  computed
} from 'vue'
import {
  checkFileSize,
  checkFileType,
  checkFileLength
} from '@/util/validation'

type Props = {
  value: undefined | File
  accept: string
  enablePreview: boolean
  fileSize: number
  fileLength: number
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
    fileSize: {
      type: Number,
      default: 1000000 // byte size
    },
    fileLength: {
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

    const imageDataValue = computed(
      (): string | ArrayBuffer | null => imageData.value
    )

    const errorTextValue = computed((): string => errorText.value)

    const isInputError = computed((): boolean => isError.value)

    const isDragedState = computed((): boolean => isDraged.value)

    // methods
    /**
     * chcek file validatiaon
     * @param {File} file
     * @return {void}
     */
    const checkFileValidation = (file: File) => {
      if (!checkFileSize(file.size, props.fileSize)) {
        isError.value = true
        errorText.value = 'invalid file size'
      } else if (!checkFileType(file.type, props.accept)) {
        isError.value = true
        errorText.value = 'invalid file type'
      } else {
        isError.value = false
        errorText.value = ''
      }
      // checkFileLength(file.size, props.fileLength)
    }

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

      if (data) {
        checkFileValidation(data)
        context.emit('update:value', data)

        if (props.enablePreview) {
          createImage(data)
        }
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

    const changeFileDrag = (event: DragEvent) => {
      if (event.dataTransfer?.files) {
        const files = event.dataTransfer?.files
        checkFileValidation(files[0])
        // const data = event.target.files ? event.target.files![0] : undefined
        context.emit('update:value', files[0])

        if (props.enablePreview) {
          createImage(files[0])
        }
      }

      // context.emit('update:value', event.dataTransfer?.files[0])
    }

    /**
     * draged status
     * @param {boolean} value
     * @return {void}
     */
    const changeDragedState = (value = false) => {
      isDraged.value = value
    }

    /**
     * drop file handler
     * @param {DragEvent} event
     * @return {void}
     */
    const dropFile = (event: DragEvent) => {
      changeFileDrag(event as DragEvent)
      changeDragedState()
    }

    return {
      inputValue,
      imageDataValue,
      errorTextValue,
      isInputError,
      isDragedState,
      fileRef,
      checkFileValidation,
      inputEventHandler,
      resetFile,
      dropFile,
      changeDragedState,
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
