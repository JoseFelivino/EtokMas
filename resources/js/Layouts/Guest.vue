<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <Link href="/">
                <ETokmasLogo class="w-36 h-36 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>

<script>
import {ETokmasLogo} from '@/Components/svg/icon';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        ETokmasLogo,
        Link,
    }
}
</script>
