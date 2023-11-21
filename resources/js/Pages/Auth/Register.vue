<template>
    <Head title="Register" />

    <BreezeValidationErrors class="mb-4" />

    <div class="inline-block cursor-pointer" @click="goBack">
        <DropDown class="transform rotate-90"/>
    </div>
    <form @submit.prevent="submit">
        <div>
            <BreezeLabel for="name" value="Nama" />
            <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
        </div>

        <div class="mt-4">
            <BreezeLabel for="email" value="Email" />
            <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
        </div>

        <div class="mt-4">
            <BreezeLabel for="address" value="Alamat" />
            <BreezeInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" required autocomplete="street-address" />
        </div>

        <div class="mt-4">
            <BreezeLabel for="dateOfBirth" value="Tanggal Lahir" />
            <BreezeInput id="dateOfBirth" type="date" class="mt-1 block w-full" v-model="form.dateOfBirth" required autocomplete="bday" />
        </div>
        
        <div class="mt-4">
            <BreezeLabel for="dateOfBirth" value="Role" />
            <select class="w-full" name="shelf_id" id="rack" v-model="form.roleId">
                <option selected="selected" value="">Pilih Role</option>
                <option value="1">Admin</option>
                <option value="2">Karyawan</option>
            </select>
        </div>

        <div class="mt-4">
            <BreezeLabel for="password" value="Password" />
            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <BreezeLabel for="password_confirmation" value="Konfirmasi Password" />
            <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="mt-10">
            <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Daftar
            </BreezeButton>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button/Link/Button.vue';
import Layout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/Validation/ValidationErrors.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { DropDown } from '@/Components/svg/icon';

export default {
    layout: Layout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
        DropDown,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                address: '',
                email: '',
                dateOfBirth: '',
                password_confirmation: '',
                password: '',
                terms: false,
                roleId: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        },
        goBack() {
            window.history.back();
        }
    }
}
</script>
