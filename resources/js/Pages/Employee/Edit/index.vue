<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { GetTitle, GetURLS } from '@/Config';
import Input from '@/Components/Input.vue';
import { Button } from '@/Components/Button/Link';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import { DateForHtml } from '@/Components/utils/Date';
import { TextValidationError } from '@/Components/Text';

export default {
    layout: NavbarLayout,

    props: {
      employee:Object,
    },

    data() {
      return {
        titlePage: GetTitle('Employee', 'edit'),
        form: this.$inertia.form({
          name: this.employee.name,
          email: this.employee.email,
          address: this.employee.address,
          dob: DateForHtml(this.employee.dob),
        }),
      }
    },

    components: {
        Head,
        Input,
        Button,
        FlashSuccessAndErrorMessage,
        TextValidationError,
    },

    methods: {
      SubmitEvent() {
        this.form.put(GetURLS('Employee', this.employee.id), {
          onSuccess: () => this.form.reset()
        });
      },
    }
}
</script>

<template>
  <Head :title="titlePage" />

  <div class="text-2xl">{{ titlePage }}</div>

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
      <label class="w-72 font-bold my-auto" for="address">Alamat</label>
      <div class="flex flex-col">
        <Input
          type="text"
          id="address"
          placeholder="Alamat"
          v-model="form.address"
        />
        <text-validation-error error="address" />
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
    <Button class="mt-8">Ubah</Button>
    <FlashSuccessAndErrorMessage class="mt-8" />
  </form>
</template>
