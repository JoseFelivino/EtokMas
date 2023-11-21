<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import NavbarLayout from "@/Layouts/Navbar.vue";
import Label from "@/Components/Label.vue";
import InputBox from "@/Components/Input.vue";
import { Button } from '@/Components/Button/Link';
import FlashSuccessAndErrorMessageVue from '@/Components/FlashSuccessAndErrorMessage.vue';
import { TextValidationError } from '@/Components/Text';

export default {
  layout: NavbarLayout,

  components: {
    Head,
    Label,
    InputBox,
    Link,
    Button,
    FlashSuccessAndErrorMessageVue,
    TextValidationError,
  },


  data() {
    return {
      formData: this.$inertia.form ({
        currentPassword: "",
        newPassword: "",
        newConfirmPassword: "",
      })
    };
  },

  methods: {
    SubmitEvent() {
      this.formData.put("/changePassword/update", {
        onSuccess: () => this.formData.reset()
      })
    }
  },
};
</script>

<template>
  <Head title="Dashboard" />

  <div class="mt-8 flex gap-2 items-center">
    <div class="text-2xl w">Ubah Password</div>
    <flash-success-and-error-message-vue />
  </div>

  <form class="mt-8 max-w-screen-sm flex flex-col gap-2" @submit.prevent="SubmitEvent">
    <div class="grid grid-cols-2">
      <label class="w-72 font-bold my-auto" for="name">Password Sekarang</label>
      <div class="flex flex-col">
        <InputBox type="password" name="currentPassword" id="currentPassword" v-model="formData.currentPassword" />
        <text-validation-error error="currentPassword" />
      </div>
    </div>
    <div class="grid grid-cols-2">
      <label class="w-72 font-bold my-auto" for="name">Password Baru</label>
      <div class="flex flex-col">
        <InputBox type="password" name="newPassword" id="newPassword" v-model="formData.newPassword" />
        <text-validation-error error="newPassword" />
      </div>
    </div>
    <div class="grid grid-cols-2">
      <label class="w-72 font-bold my-auto" for="name">Konfirmasi Password</label>
      <div class="flex flex-col">
        <InputBox type="password" name="newConfirmPassword" id="newConfirmPassword" v-model="formData.newConfirmPassword" />
        <text-validation-error error="newConfirmPassword" />
      </div>
    </div>
    <Button class="mt-6">Simpan</Button>
  </form>
</template>
