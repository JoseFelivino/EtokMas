<template>
    <button :type="type" :class="[isFullWidth && 'w-full', 'p-2 flex items-center justify-center rounded-lg h-10 border-2 transition-colors border-blue-300 hover:bg-blue-700 hover:border-blue-700 hover:text-white']">
        <slot />
    </button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: 'submit',
        },
        isFullWidth: {
            type: Boolean,
            default: true,
        },
    }
}
</script>
