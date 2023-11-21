<template>
    <Head title="Log in" />

    <BreezeValidationErrors class="mb-4" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="submit">
        <div>
            <BreezeLabel for="email" value="Email" />
            <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
        </div>

        <div class="mt-4">
            <BreezeLabel for="password" value="Password" />
            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
        </div>

        <div class="block mt-4">
            <label class="w-max flex items-center cursor-pointer">
                <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="mt-10">
            <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Log in
            </BreezeButton>

            <div class="mt-1 flex justify-end">
                <Link v-if="canResetPassword" :href="route('password.request')" class="text-xs text-red-900 text-right hover:text-gray-900">
                    Forgot your password?
                </Link>
            </div>
        </div>
    </form>
</template>

<script>
import Layout from '@/Layouts/Guest.vue'
import BreezeButton from '@/Components/Button/Link/Button.vue'
import BreezeCheckbox from '@/Components/Button/Checkbox.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/Validation/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    layout: Layout,

    components: {
        BreezeButton,
        BreezeCheckbox,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
    },

    props: {
        canResetPassword: Boolean,
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('login'), {
                onFinish: () => this.form.reset('password'),
            })
        }
    }
}
</script>
