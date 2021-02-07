<template>
  <div class="liner-loading" v-show="open">
    <div class="liner-loading__content">
      <ProgressBar value="0" mode="indeterminate" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import ProgressBar from 'primevue/progressbar'

type Props = {
  open: boolean
}

export default defineComponent({
  name: 'LinerLoading',
  components: {
    ProgressBar
  },
  props: {
    open: {
      type: Boolean,
      default: false
    }
  },
  setup() {
    return {}
  }
})
</script>
<style lang="scss" scoped>
.liner-loading {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1000;
  background-color: rgb(177, 177, 177);
  pointer-events: auto;
  transition: 0.3s linear;

  &__content {
    margin: 50px 0 0 0;
    .p-progressbar {
      height: 10px;
    }
  }
}
</style>
