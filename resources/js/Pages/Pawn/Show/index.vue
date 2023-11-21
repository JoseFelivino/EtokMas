<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { GetTitle } from '@/Config';
import Label from '@/Components/Label.vue';
import InputVue from '@/Components/Input.vue';
import Button from '@/Components/Button/Link/Button.vue';
import { RupiahFormat, PercentFormat } from '@/Components/utils/Number';
import FlashSuccessAndErrorMessageVue from '@/Components/FlashSuccessAndErrorMessage.vue';

export default {
  layout: NavbarLayout,

  props: {
    pawnTransactionHeader: Object,
  },

  data() {
    return {
      titlePage: GetTitle('GoldPawn', 'create'),
    }
  },

  components: {
    Head,
    Label,
    InputVue,
    Button,
    FlashSuccessAndErrorMessageVue,
  },

  methods: {
    RupiahFormat,
    PercentFormat,
  }
}
</script>

<template>
  <Head :title="titlePage" />

  <div class="flex gap-2 items-center">
    <div class="text-2xl">{{ titlePage }}</div>
    <flash-success-and-error-message-vue />
  </div>

  <form class="mt-8 flex flex-col gap-2 max-w-screen-sm">
    <div class="grid grid-cols-2">
      <Label class="w-72 font-bold my-auto" value="ID Gadai" />
      <InputVue class="mt-1" type="text" :value="pawnTransactionHeader.id" disabled />
    </div>
    <div class="grid grid-cols-2">
      <Label class="w-72 font-bold my-auto" value="Nama Penjaga" />
      <InputVue class="mt-1" type="text" :value="pawnTransactionHeader.user.name" disabled />
    </div>
    <div class="grid grid-cols-2">
      <Label class="w-72 font-bold my-auto" value="Nama Customer" />
      <InputVue class="mt-1" type="text" :value="pawnTransactionHeader.customer.name" disabled />
    </div>
    <div class="grid grid-cols-2">
      <Label class="w-72 font-bold my-auto" value="Batas Pembayaran" />
      <InputVue class="mt-1" type="text" :value="pawnTransactionHeader.deadline_date" disabled />
    </div>
    <div class="grid grid-cols-2">
      <Label class="w-72 font-bold my-auto" value="Dana Pinjaman" />
      <InputVue class="mt-1" type="text" :value="RupiahFormat(pawnTransactionHeader.loan_price)" disabled />
    </div>
    <div class="grid grid-cols-2">
      <Label class="w-72 font-bold my-auto" value="Dana Tebusan" />
      <InputVue class="mt-1" type="text" :value="RupiahFormat(pawnTransactionHeader.return_price)" disabled />
    </div>
    <div class="grid grid-cols-2">
      <Label class="w-72 font-bold my-auto" value="Total Bunga" />
      <InputVue class="mt-1" type="text" :value="PercentFormat(pawnTransactionHeader.interest_total)" disabled />
    </div>
  </form>
</template>
