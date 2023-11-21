<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLSub, GetURLSUpdateGoldCarat } from '@/Config';
import Input from '@/Components/Input.vue';
import { Button } from '@/Components/Button/Link';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'

// const { title } = GetEditGoldCarat(this.goldCaratCategory);

export default {
  layout: NavbarLayout,

  props: {
    goldCaratCategory: Object,
  },

  data() {
    return {
      URLSub,
      form: this.$inertia.form({
        carat: this.goldCaratCategory.carat,
        price: this.goldCaratCategory.price,
        fee: this.goldCaratCategory.fee,
      }),
    };
  },

  components: {
      Head,
      Input,
      FlashSuccessAndErrorMessage,
      Button,
  },

  methods: {
    SubmitEvent() {
      this.form.put(GetURLSUpdateGoldCarat(this.goldCaratCategory.id), {
        onSuccess: () => this.form.reset()
      });
    },
  },
}
</script>

<template>
  <Head :title="URLSub.editGoldCarat.title" />

  <div class="text-2xl">{{ URLSub.editGoldCarat.title }}</div>

  <form class="mt-8 max-w-screen-sm" @submit.prevent="SubmitEvent">
    <div class="grid grid-cols-2">
      <label class="w-72 font-bold my-auto" for="name">Karat</label>
      <Input
        type="number"
        id="name"
        placeholder="Karat"
        v-model="form.carat"
        autofocus
      />
      <!-- <div class="text-red-500" v-if="errors.carat">{{ errors.carat }}</div> -->
    </div>
    <div class="grid grid-cols-2 mt-4">
      <label class="w-72 font-bold my-auto" for="price">Harga</label>
      <Input
        type="number"
        id="price"
        placeholder="Harga"
        step="1000"
        v-model="form.price"
      />
      <!-- <div class="text-red-500" v-if="errors.price">{{ errors.price }}</div> -->
    </div>
    <div class="grid grid-cols-2 mt-4">
      <label class="w-72 font-bold my-auto" for="fee">Biaya/Potongan</label>
      <Input
        type="number"
        id="fee"
        placeholder="Biaya"
        step="1000"
        v-model="form.fee"
      />
      <!-- <div class="text-red-500" v-if="errors.fee">{{ errors.fee }}</div> -->
    </div>
    <Button class="mt-8">Ubah</Button>
    <FlashSuccessAndErrorMessage class="mt-8" />
  </form>
</template>
