<template>
    <button :type="type" class="w-full p-2 flex items-center justify-center rounded-lg h-10 border-2 transition-colors border-red-300 hover:bg-red-700 hover:border-red-700 hover:text-white">
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
    }
}
</script>
