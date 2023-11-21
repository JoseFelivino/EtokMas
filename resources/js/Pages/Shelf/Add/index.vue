<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLS, URLSub } from '@/Config';
import Input from "@/Components/Input.vue";
import { Button } from "@/Components/Button/Link";
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import { TextValidationError } from '@/Components/Text';

export default {
  layout: NavbarLayout,

  data() {
    return {
      URLSub,
      form: this.$inertia.form({
        name: '',
      })
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
      this.form.post(URLS.Shelf.href, {
        onSuccess: () => this.form.reset()
      })
    }
  }
}
</script>

<template>
  <Head :title="URLSub.addShelf.title" />

  <div class="flex gap-2 mt-8 items-center">
    <div class="text-2xl">{{ URLSub.addShelf.title }}</div>
    <flash-success-and-error-message />
  </div>

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
    <Button class="mt-8">Simpan</Button>
  </form>
</template>
