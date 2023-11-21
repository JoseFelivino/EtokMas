<script>
export default {
  props: {
    className: {
      type: String,
      default: '',
    },
    minWidth: {
      type: String,
      default: '',
    },
    zIndex: {
      type: Number,
      default: 1,
    },
  },

  data() {
    return {
      zIndexArray: {
        '1': [
          '10',
          '20',
        ],
        '2': [
          '30',
          '40',
        ],
        '4': [
          '50',
          '60',
        ],
        '5': [
          '70',
          '80',
        ],
        '6': [
          '90',
          '100',
        ],
      },
    };
  },

  methods: {
    closeModal() {
      this.$emit('close')
    }
  },

  emits: ['close']
}
</script>

<style scoped>
  .content {
    -ms-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
  }
</style>

<template>
    <div
      :class="[
        'fixed left-0 top-0 w-screen h-screen',
        'bg-black opacity-80',
        `z-${zIndexArray[zIndex][0]}`,
      ]"
      @click="closeModal"
    />
    <div :class="['content',
      'fixed w-max p-8 bg-white opacity-100 rounded-md',
      'top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 border-2 border-blue-700',
      `z-${zIndexArray[zIndex][1]}`,
      minWidth ? minWidth : 'min-w-96',
      className,
    ]">
      <div class="relative">
        <div class="absolute -right-6 -top-6 cursor-pointer" @click="closeModal">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
      </div>
      <slot />
    </div>
</template>
