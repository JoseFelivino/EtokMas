<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLSub, GetURLSUpdateCategory } from '@/Config';
import Input from '@/Components/Input.vue';
import { Button } from '@/Components/Button/Link';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import ValidationErrors from '@/Components/Validation/ValidationErrors.vue';

export default {
    layout: NavbarLayout,

    props: {
      category:Object,
    },

    data() {
      return {
        URLSub,
        form: this.$inertia.form({
          name: this.category.name,
        }),
      }
    },

    components: {
        Head,
        Input,
        Button,
        FlashSuccessAndErrorMessage,
        ValidationErrors,
    },

    methods: {
      SubmitEvent() {
        this.form.put(GetURLSUpdateCategory(this.category.id, {
          onSuccess: () => this.form.reset()
        }))
      },
    }
}
</script>

<template>
  <Head :title="URLSub.editCategory.title" />

  <div class="text-2xl">{{ URLSub.editCategory.title }}</div>

  <validation-errors class="mt-8" />

  <form class="mt-8 max-w-screen-sm" @submit.prevent="SubmitEvent">
    <div class="grid grid-cols-2">
      <label class="w-72 font-bold my-auto" for="name">Nama Kategori</label>
      <Input
        type="text"
        id="name"
        placeholder="Nama"
        v-model="form.name"
        autofocus
      />
    </div>
    <Button class="mt-8">Ubah</Button>
    <FlashSuccessAndErrorMessage class="mt-8" />
  </form>
</template>
