<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLS, GetTitle } from '@/Config';
import Input from "@/Components/Input.vue";
import { Button } from "@/Components/Button/Link";
import ValidationErrors from '@/Components/Validation/ValidationErrors.vue';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage.vue';
import { TextValidationError } from '@/Components/Text';

export default {
  layout: NavbarLayout,

  data() {
    return {
      titlePage: GetTitle('GoldCarat', 'add'),
      form: this.$inertia.form({
        carat: "",
        price: "",
        fee: "",
      }),
    }
  },

  components: {
    Head,
    Link,
    Button,
    Input,
    TextValidationError,
    FlashSuccessAndErrorMessage,
  },

  methods: {
    SubmitEvent() {
      this.form.post(URLS.GoldCarat.href, {
        onSuccess: () => this.form.reset()
      })
    }
  }
}
</script>

<template>
  <Head :title="titlePage" />

  <div class="flex gap-2 items-center">
    <div class="text-2xl">{{ titlePage }}</div>
    <flash-success-and-error-message />
  </div>

  <form class="mt-8 max-w-screen-sm" @submit.prevent="SubmitEvent">
    <div class="grid grid-cols-2">
      <label class="w-72 font-bold my-auto" for="name">Karat</label>
      <div class="flex flex-col">
        <Input
          type="number"
          id="name"
          placeholder="Karat"
          v-model="form.carat"
          autofocus
        />
        <text-validation-error error="carat" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-4">
      <label class="w-72 font-bold my-auto" for="price">Harga</label>
      <div class="flex flex-col">
        <Input
          type="number"
          id="price"
          placeholder="Harga"
          step="1000"
          v-model="form.price"
        />
        <text-validation-error error="price" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-4">
      <label class="w-72 font-bold my-auto" for="fee">Biaya/Potongan</label>
      <div class="flex flex-col">
        <Input
          type="number"
          id="fee"
          placeholder="Biaya"
          step="1000"
          v-model="form.fee"
        />
        <text-validation-error error="fee" />
      </div>
    </div>
    <Button class="mt-8"> Tambah </Button>
  </form>
</template>
