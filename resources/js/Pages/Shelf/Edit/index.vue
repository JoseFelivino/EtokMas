<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLSub, GetURLSUpdateShelf } from '@/Config';
import Input from '@/Components/Input.vue';
import { Button } from '@/Components/Button/Link';
import { FormValidationErrors } from '@/Components/Validation';

export default {
    layout: NavbarLayout,

    props: {
      shelf:Object,
    },

    data() {
      return {
        URLSub,
        form: this.$inertia.form({
          name: this.shelf.name,
        }),
      }
    },

    components: {
        Head,
        Input,
        Button,
        FormValidationErrors,
    },

    methods: {
      SubmitEvent() {
        this.form.put(GetURLSUpdateShelf(this.shelf.id, {
          onSuccess: () => this.form.reset()
        }))
      },
    }
}
</script>

<template>
  <Head :title="URLSub.editShelf.title" />

  <div class="text-2xl">{{ URLSub.editShelf.title }}</div>

  <form-validation-errors class="mt-8" />

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
    <Button class="mt-8">Ubah</Button>
  </form>
</template>
