<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { GetURLS, URLS, URLSub } from '@/Config';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button/Link/Button.vue';
import ValidationErrors from '@/Components/Validation/ValidationErrors.vue';
import { DateForHtml } from '@/Components/utils/Date';

export default {
  layout: NavbarLayout,

  props: {
    customer: Object,
  },

  data() {
    return {
      URLS,
      URLSub,
      form: this.$inertia.form({
        email: this.customer.email,
        name: this.customer.name,
        phone_number: this.customer.phone_number,
        dob: DateForHtml(this.customer.dob),
      }),
    }
  },

  components: {
    Head,
    Input,
    Button,
    ValidationErrors,
  },

  methods: {
    SubmitEvent() {
      this.form.put(GetURLS('Customer', this.customer.id), {
        onSuccess: () => this.form.reset()
      })
    },
  },
}
</script>

<template>
  <Head :title="URLSub.editCustomer.title" />

  <div class="text-2xl">{{ URLSub.editCustomer.title }}</div>

  <validation-errors class="mt-8" />
  
  <form class="mt-8 max-w-screen-sm" @submit.prevent="SubmitEvent">
    <div class="grid grid-cols-2">
      <label class="w-72 font-bold my-auto" for="name">Nama</label>
      <Input
        type="text"
        id="name"
        placeholder="Nama"
        v-model="form.name"
        autofocus
      />
    </div>
    <div class="grid grid-cols-2 mt-2">
      <label class="w-72 font-bold my-auto" for="email">Email</label>
      <Input
        type="text"
        id="email"
        placeholder="Email"
        v-model="form.email"
      />
    </div>
    <div class="grid grid-cols-2 mt-2">
      <label class="w-72 font-bold my-auto" for="phoneNumber">Nomor Telepon</label>
      <Input
        type="text"
        id="phoneNumber"
        placeholder="Nomor Telepon"
        v-model="form.phone_number"
      />
    </div>
    <div class="grid grid-cols-2 mt-2">
      <label class="w-72 font-bold my-auto" for="dob">Tanggal Lahir</label>
      <Input
        type="date"
        id="dob"
        placeholder="Tanggal Lahir"
        v-model="form.dob"
      />
    </div>
    <Button class="mt-8">Ubah</Button>
  </form>
</template>
