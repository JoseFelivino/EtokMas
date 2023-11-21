<script>
import vClickOutside from 'click-outside-vue3'
export default {
  data() {
    return {
      isShow: false,
    }
  },

  directives: {
    clickOutside : vClickOutside.directive,
  },

  methods: {
    onClick() {
      this.isShow = !this.isShow
    },
    onClickOutside() {
      this.isShow = false;
    },
  },
  
  computed: {
    isActive() {
      return this.isShow ? null : 'hidden'
    },
  },
}
</script>

<template>
  <div class="relative w-full h-full min-h-10 z-5 focus-within:border-blue-300" v-click-outside="onClickOutside">
    <div
      class="min-w-full min-h-full w-max rounded-md bg-blue-300 hover:bg-blue-700 hover:text-white flex items-center justify-center transition-colors cursor-pointer"
      @click="onClick"
    >
      <slot name="title"/>
    </div>
    <div :class="[
      'absolute mt-2 p-4 bg-white rounded-md shadow-lg min-w-96',
      isActive,
    ]">
      <slot name="content">*default*</slot>
    </div>
  </div>
</template>
