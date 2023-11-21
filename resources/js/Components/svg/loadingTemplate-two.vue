<script>
export default {
  props: {
    radius: {
      type: Number,
      default: 30,
    },
    width: {
      type: Number,
      default: 60,
    },
    height: {
      type: Number,
      default: 60,
    },
  }
}
</script>


<template>
  <svg class="mx-auto" :width="width" :height="height">
    <circle :cx="width/2" :cy="height/2" :r="radius" fill="#B08C77" />
    Sorry, your browser does not support inline SVG.  
  </svg>
</template>