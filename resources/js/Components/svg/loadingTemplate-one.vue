<script>
export default {
  props: {
    width: {
      type: Number,
      default: 97,
    },
    height: {
      type: Number,
      default: 97,
    },
  }
}
</script>

<template>
  <svg :width="width" :height="height" viewBox="0 0 1 1">
    <rect fill="#B08C77" width="1" height="1"/>
  </svg>
</template>