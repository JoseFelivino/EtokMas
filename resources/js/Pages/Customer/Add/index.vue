<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { GetURLS, URLS, URLSub } from '@/Config';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button/Link/Button.vue';
import { TextValidationError } from '@/Components/Text';

export default {
  layout: NavbarLayout,

  data() {
    return {
      URLS,
      URLSub,
      form: this.$inertia.form({
        email: '',
        name: '',
        phone_number: '',
        dob: '',
      }),
    }
  },

  components: {
    Head,
    FlashSuccessAndErrorMessage,
    Input,
    Button,
    TextValidationError,
  },

  methods: {
    SubmitEvent() {
      this.form.post(GetURLS('Customer'), {
        onSuccess: () => this.form.reset()
      })
    },
  },
}
</script>

<template>
  <Head :title="URLSub.addCustomer.title" />

  <div class="text-2xl">{{ URLSub.addCustomer.title }}</div>

  <form class="mt-8 max-w-screen-sm" @submit.prevent="SubmitEvent">
    <div class="grid grid-cols-2">
      <label class="w-72 font-bold my-auto" for="name">Nama</label>
      <div class="flex flex-col">
        <Input
          type="text"
          id="name"
          placeholder="Nama"
          v-model="form.name"
          autofocus
        />
        <text-validation-error error="name" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-2">
      <label class="w-72 font-bold my-auto" for="email">Email</label>
      <div class="flex flex-col">
        <Input
          type="text"
          id="email"
          placeholder="Email"
          v-model="form.email"
        />
        <text-validation-error error="email" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-2">
      <label class="w-72 font-bold my-auto" for="phoneNumber">Nomor Telepon</label>
      <div class="flex flex-col">
        <Input
          type="text"
          id="phoneNumber"
          placeholder="Nomor Telepon"
          v-model="form.phone_number"
        />
        <text-validation-error error="phone_number" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-2">
      <label class="w-72 font-bold my-auto" for="dob">Tanggal Lahir</label>
      <div class="flex flex-col">
        <Input
          type="date"
          id="dob"
          placeholder="Tanggal Lahir"
          v-model="form.dob"
        />
        <text-validation-error error="dob" />
      </div>
    </div>
    <Button class="mt-8">Simpan</Button>
    <flash-success-and-error-message class="mt-8" />
  </form>
</template>
