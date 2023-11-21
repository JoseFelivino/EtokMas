<script>
import TextSmallVue from './TextSmall.vue'
export default {
  props: {
    error: {
      type: String,
      required: true,
    },
  },

  components: {
    TextSmallVue,
  },

  computed: {
    errors() {
      return this.$page.props.errors
    },

    hasErrors() {
      return Object.keys(this.errors).length > 0
    },
  }
}
</script>

<template>
  <text-small-vue v-if="hasErrors" color="text-red-700" :pointer="false">{{ errors[error] }}</text-small-vue>
</template>