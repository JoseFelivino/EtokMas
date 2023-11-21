<script>
export default {
  props: {
    color: {
      type: String,
      required: false,
      default: 'text-black'
    },
    pointer: {
      type: Boolean,
      required: false,
      default: true,
    }
  },
}
</script>

<template>
  <span :class="[
    pointer && 'cursor-pointer',
    'text-sm font-light my-auto',
    color,
  ]"><slot>Please insert Text</slot></span>
</template>