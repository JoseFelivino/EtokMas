<script>

export default {
  props: {
    text: {
      type: String,
      required: true,
      default: 'Please insert text'
    }
  }
}
</script>

<template>
  <div class="rounded-md p-2 bg-red-300  inline text-white">
    <span>{{ text }}</span>
  </div>
</template>
