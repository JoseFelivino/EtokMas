<template>
  <div class="min-h-10">
    <input ref="file" type="file" :accept="accept" class="hidden" @change="change" />
    <button v-if="!modelValue" type="button" class="min-w-full min-h-full w-max rounded-md bg-blue-300 hover:bg-blue-700 hover:text-white flex items-center justify-center transition-colors cursor-pointer" @click="browse">Cari File</button>
    <div v-else class="flex items-center justify-between">
      <div class="flex-1 pr-1">
        {{ modelValue.name }} <span class="text-gray-500 text-xs">({{ filesize(modelValue.size) }})</span>
      </div>
      <text-small type="button" class="px-4 py-1 text-xs font-medium" color="text-red-700" @click="remove">Hapus</text-small>
    </div>
  </div>
</template>

<script>
import { TextSmall } from './Text';

export default {
  props: {
    modelValue: File,
    accept: String,
  },
  emits: ['update:modelValue'],
  watch: {
    modelValue(value) {
      if (!value) {
        this.$refs.file.value = ''
      }
    },
  },
  components: {
    TextSmall,
  },
  methods: {
    filesize(size) {
      var i = Math.floor(Math.log(size) / Math.log(1024))
      return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
    },
    browse() {
      this.$refs.file.click()
    },
    change(e) {
      this.$emit('update:modelValue', e.target.files[0])
    },
    remove() {
      this.$emit('update:modelValue', null)
    },
  },
}
</script>
