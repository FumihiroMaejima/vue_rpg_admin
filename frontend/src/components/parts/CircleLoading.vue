<template>
  <div class="circle-loading" v-show="open">
    <div class="circle-loading__content">
      <ProgressSpinner />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import ProgressSpinner from 'primevue/progressspinner'

type Props = {
  open: boolean
}

export default defineComponent({
  name: 'CircleLoading',
  components: {
    ProgressSpinner
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
.circle-loading {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1000;
  background-color: rgba(0, 0, 0, 0.4);
  pointer-events: auto;
  transition: 0.3s linear;

  &__content {
    position: fixed;
    top: 45%;
    left: 45%;
  }
}
</style>
