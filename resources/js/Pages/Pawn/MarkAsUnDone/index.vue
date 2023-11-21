<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { FormValidationErrors } from '@/Components/Validation';
import InputVue from '@/Components/Input.vue';
import Label from '@/Components/Label';
import { Button } from '@/Components/Button/Link';
import { DateForHtml } from '@/Components/utils/Date';
import { RupiahFormat, PercentFormat } from '@/Components/utils/Number';

export default {
  layout: NavbarLayout,

  props: {
    pawnTransactionHeader: Object,
  },

  data() {
    return {
      pageTitle: 'Buka kembali transaksi gadai yang sudah selesai',
      formData: this.$inertia.form({
        deadlineDate: DateForHtml(this.pawnTransactionHeader.deadline_date),
      }),
      localData: {
        tempo: 0,
        interest: this.pawnTransactionHeader.interest_total / (Math.abs(this.getDifferenceBetweenDateString(DateForHtml(this.pawnTransactionHeader.deadline_date), DateForHtml(this.pawnTransactionHeader.created_at)) || 1)),
      },
    }
  },

  components: {
    Head,
    InputVue,
    Label,
    Button,
    FormValidationErrors,
  },

  methods: {
    DateForHtml,
    RupiahFormat,
    PercentFormat,
    SubmitEvent(id) {
      this.formData.put(`/markPawnTransactionHeaderAsUnDone/${id}`, {
        onSuccess: () => this.form.reset()
      })
    },
    getDifferenceBetweenDateString(dateOne, dateTwo) {
      var date1 = new Date(dateOne)
      var date2 = new Date(dateTwo)
      var Difference_In_Time = date2.getTime() - date1.getTime()
      return Difference_In_Time / (1000 * 3600 * 24)
    },
    onChangeDeadlineDate() {
      var diffDate =  Math.ceil(
        this.getDifferenceBetweenDateString(
          DateForHtml(this.pawnTransactionHeader.created_at), 
          this.formData.deadlineDate
        )
      )
      if (diffDate < 0) {
        this.formData.deadlineDate = new Date().toISOString().slice(0, 10)
        this.localData.tempo = 0
      }
      else this.localData.tempo = diffDate
    },
  },

  computed: {
    TotalInterest() {
      return this.localData.interest * this.localData.tempo;
    },
    TotalPrice() {
      const interestPrice = this.TotalInterest * this.pawnTransactionHeader.loan_price / 100;
      const price = parseFloat(this.pawnTransactionHeader.loan_price) + parseFloat(interestPrice);
      return price
    },
  },

  mounted() {
    this.onChangeDeadlineDate();
  },
}
</script>

<template>
  <Head :title="pageTitle" />

  <div class="text-2xl">{{ pageTitle }}</div>

  <form-validation-errors class="mt-8" />

  <form class="mt-8 max-w-screen-sm" @submit.prevent="SubmitEvent(pawnTransactionHeader.id)">
      <div class="flex gap-2 items-center">
        <div class="w-48">
          <Label class="font-bold" value="Nama Customer" />
        </div>
        <div class="min-w-96 flex items-center">
          <span class="font-bold">: {{pawnTransactionHeader.customer.name}}</span>
        </div>
      </div>
      <div class="flex gap-2 items-center mt-2">
        <div class="w-48">
          <Label class="font-bold" value="Nama Penjaga" />
         </div>
         <div class="min-w-96 flex items-center">
           <span>: {{pawnTransactionHeader.user.name}}</span>
         </div>
       </div>
       <div class="flex gap-2 items-center mt-2">
         <div class="w-48">
           <Label class="font-bold" value="Status Transaksi" />
         </div>
         <div class="min-w-96 flex items-center">
           <span>: {{pawnTransactionHeader.pawn_transaction_status.status == 'undone' ? 'Belum Selesai' : 'Sudah Selesai'}}</span>
         </div>
       </div>
    <div class="flex space-x-32 w-full mt-11">
      <div class="flex-row">
        <div class="flex gap-2 items-center mt-2">
            <div class="w-48">
              <Label class="w-72 font-bold my-auto" value="Tanggal Gadai" />
            </div>
            <div class="min-w-96 flex items-center">
              <span>: {{pawnTransactionHeader.created_at}}</span>
            </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
            <div class="w-48">
              <Label class="w-72 font-bold my-auto" value="Batas Pembayaran Sekarang" />
            </div>
            <div class="min-w-96 flex items-center">
              <span>: {{pawnTransactionHeader.deadline_date}}</span>
            </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
          <div class="w-48">
            <Label class="w-72 font-bold my-auto" value="Batas Pembayaran" />
          </div>
          <div class="flex flex-col">
            <div class="min-w-96 flex items-center">
              <InputVue class="mt-1" type="date" v-model="formData.deadlineDate" @change="onChangeDeadlineDate()" />
            </div>
          </div>
        </div>
        <div class="flex gap-2 items-center mt-2">
          <div class="w-48">
            <Label class="w-72 font-bold my-auto" value="Total Tempo" />
          </div>
          <div class="flex flex-col">
            <div class="min-w-96 flex items-center">
              <InputVue class="mt-1" type="text" v-model="localData.tempo" disabled />
            </div>
          </div>
        </div>
      </div>
      <div class="flex-row">
          <div class="flex gap-2 items-center mt-2">
            <div class="w-48">
              <Label class="font-bold" value="Dana Pinjaman" />
            </div>
            <div class="min-w-96 flex items-center">
              <span>: {{RupiahFormat(pawnTransactionHeader.loan_price)}}</span>
            </div>
          </div>
          <div class="flex gap-2 items-center mt-2">
            <div class="w-48">
              <Label class="font-bold" value="Dana Tebusan" />
            </div>
            <div class="min-w-96 flex items-center">
              <span class="font-bold">: {{RupiahFormat(TotalPrice)}}</span>
            </div>
          </div>
          <div class="flex gap-2 items-center mt-2">
            <div class="w-48">
              <Label class="font-bold" value="Total Bunga" />
            </div>
            <div class="min-w-96 flex items-center">
              <span class="font-bold">: {{PercentFormat(TotalInterest)}}</span>
            </div>
          </div>
      </div>
    </div>

    <Button class="mt-8">Buka Kembali Transaksi</Button>

  </form>
</template>
