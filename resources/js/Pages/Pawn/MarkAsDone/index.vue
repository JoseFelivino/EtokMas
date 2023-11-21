<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { GetTitle, isGreenOrRedColor } from '@/Config';
import Label from '@/Components/Label.vue';
import InputVue from '@/Components/Input.vue';
import Button from '@/Components/Button/Link/Button.vue';
import { FormValidationErrors } from '@/Components/Validation';
import { RupiahFormat } from '@/Components/utils/Number';

export default {
  layout: NavbarLayout,

  props: {
    customerName: String,
    pawnTransactionStatus: String,
    userName: String,
    deadlineDate: String,
    currentDate: String,
    loanPrice: Number,
    returnPrice: Number,
    totalInterest: Float32Array,
    created_at: String,
    dateDifferenceBetweenTodayAndDeadline: Number,
    isLate: Boolean,
    currentTempo: Number,
    pawnTransactionHeaderId: Number,
    firstTempo: Number
  },

  data() {
    return {
      titlePage: "Selesaikan Transaksi Gadai",
      dataForm: this.$inertia.form({
        returnPrice: this.returnPrice,
        totalInterest: this.totalInterest,
      }),
    }
  },

  components: {
    Head,
    Label,
    InputVue,
    Button,
    FormValidationErrors,
  },

  methods: {
    RupiahFormat,
    isGreenOrRedColor,
    SubmitEvent() {
      this.dataForm.put(`/markPawnTransactionHeaderAsDone/${this.pawnTransactionHeaderId}`, {
        onSuccess: () => this.form.reset()
      })
    }
  }
}
</script>

<template>
  <Head :title="titlePage" />

  <div class="text-2xl">{{ titlePage }}</div>

  <form-validation-errors class="mt-8" />

  <form class="mt-8 max-w-screen-sm" @submit.prevent="SubmitEvent()">

    <div class="flex space-x-32 w-full mb-11">
      <div class="flex-row">
        <div class="flex gap-2 items-center">
          <div class="w-48">
            <Label class="font-bold" value="Nama Customer" />
          </div>
          <div class="min-w-96 flex items-center">
            <span class="font-bold">: {{customerName}}</span>
          </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
          <div class="w-48">
            <Label class="font-bold" value="Nama Penjaga" />
          </div>
          <div class="min-w-96 flex items-center">
            <span>: {{userName}}</span>
          </div>
        </div>
        <div class="flex gap-2 items-center">
          <div class="w-48">
            <Label class="font-bold" value="Status Keterlambatan" />
          </div>
          <div class="min-w-96 flex items-center">
            <span :class="[
              isGreenOrRedColor(isLate ? '0' : '1'),
              'mt-1',
            ]">: {{isLate ? 'Terlambat' : 'Tepat Waktu'}}</span>
          </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
          <div class="w-48">
            <Label class="font-bold" value="Status Transaksi" />
          </div>
          <div class="min-w-96 flex items-center">
            <span>: {{pawnTransactionStatus == 'undone' ? 'Belum Selesai' : 'Sudah Selesai'}}</span>
          </div>
        </div>
      </div>
      <div class="flex-row">
        <div class="flex gap-2 items-center">
          <div class="w-48">
            <Label class="font-bold" value="Tanggal Gadai" />
          </div>
          <div class="min-w-96 flex items-center">
            <span  >: {{created_at}}</span>
          </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
          <div class="w-48">
            <Label class="font-bold" value="Batas Pembayaran" />
          </div>
          <div class="min-w-96 flex items-center">
            <span class="line-through" >: {{deadlineDate}}</span>
          </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
          <div class="w-48">
            <Label class="font-bold" value="Batas Pembayaran Sekarang" />
          </div>
          <div class="min-w-96 flex items-center">
            <span  >: {{currentDate}}</span>
          </div>
        </div>
      </div>
    </div>
    
    <div class="flex space-x-32 w-full mt-11">
      <div class="flex-row">
        <div class="flex gap-2 items-center">
          <div class="w-48">
            <Label class="font-bold" value="Dana Pinjaman" />
          </div>
          <div class="min-w-96 flex items-center">
            <span>: {{RupiahFormat(loanPrice)}}</span>
          </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
          <div class="w-48">
            <Label class="font-bold" value="Dana Tebusan" />
          </div>
          <div class="min-w-96 flex items-center">
            <InputVue type="text" :modelValue="dataForm.returnPrice" />
          </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
          <div class="w-48">
            <Label class="font-bold" value="Total Bunga" />
          </div>
          <div class="min-w-96 flex gap-2 items-center">
            <InputVue type="text" :modelValue="dataForm.totalInterest" />%
          </div>
        </div>
      </div>
      <div class="flex-row">
        <div class="flex gap-2 items-center">
          <div class="w-48">
            <Label class="font-bold" value="Lama Gadai" />
          </div>
          <div class="min-w-96 flex items-center">
            <span class="line-through" >: {{firstTempo}} hari</span>
          </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
          <div class="w-48">
            <Label class="font-bold" value="Lama Gadai Sekarang" />
          </div>
          <div class="min-w-96 flex items-center">
            <span>: {{currentTempo}} hari</span>
          </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
          <div class="w-48">
            <Label class="font-bold" value="Perbedaan Lama Gadai" />
          </div>
          <div class="min-w-96 flex items-center">
            <span>: {{dateDifferenceBetweenTodayAndDeadline}} hari</span>
          </div>
        </div>
      </div>
    </div>
    <Button class="mt-8">Selesaikan Transaksi</Button>
  </form>
</template>
