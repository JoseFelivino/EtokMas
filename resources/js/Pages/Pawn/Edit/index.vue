<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { GetTitle, GetURLS } from '@/Config';
import { RupiahFormat } from '@/Components/utils/Number';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import Button from '@/Components/Button/Link/Button.vue';
import ValidationErrors from '@/Components/Validation/ValidationErrors.vue';
import { DateForHtml } from '@/Components/utils/Date';

export default {
  layout: NavbarLayout,

  props: {
    pawnTransactionHeader: Object,
  },

  data() {
    return {
      titlePage: GetTitle('GoldPawn', 'edit'),
      interest: this.pawnTransactionHeader.interest_total / (Math.abs(this.getDifferenceBetweenDateString(DateForHtml(this.pawnTransactionHeader.deadline_date), DateForHtml(this.pawnTransactionHeader.created_at)) || 1)),
      dataPawn: this.$inertia.form({
        customerId: this.pawnTransactionHeader.customer.id,
        pawnTransactionStatusId: this.pawnTransactionHeader.pawn_transaction_status_id,
        customerName: this.pawnTransactionHeader.customer.name,
        itemPrice: this.pawnTransactionHeader.item_price,
        pawnPrice: this.pawnTransactionHeader.loan_price,
        tempo: 0,
        deadlineDate: DateForHtml(this.pawnTransactionHeader.deadline_date),
        interestTotal: this.pawnTransactionHeader.interest_total,
        totalPrice: this.pawnTransactionHeader.return_price,
      }),
    }
  },

  components: {
    Head,
    Input,
    Label,
    Button,
    ValidationErrors,
  },

  methods: {
    RupiahFormat,
    DateForHtml,
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
          this.dataPawn.deadlineDate
        )
      )
      if (diffDate < 0) {
        this.dataPawn.deadlineDate = new Date().toISOString().slice(0, 10)
        this.dataPawn.tempo = 0
      }
      else this.dataPawn.tempo = diffDate
    },
    onClickSave() {
      this.dataPawn.totalPrice = this.TotalPrice;
      this.dataPawn.put(GetURLS('GoldPawn', this.pawnTransactionHeader.id), {
        onSuccess: () => this.dataPawn.reset()
      })
    },
  },

  computed: {
    TotalPrice() {
        const totalInterest = (this.dataPawn.interestTotal * this.dataPawn.tempo) / 100
        const interestPrice = totalInterest * this.dataPawn.pawnPrice
        const price = parseInt(this.dataPawn.pawnPrice) + parseInt(interestPrice)
        return price
    },
  },

  mounted() {
    this.onChangeDeadlineDate()
  },
}
</script>

<template>
  <Head :title="titlePage" />

  <div class="text-2xl">{{ titlePage }}</div>

  <validation-errors />
  
  <div class="mt-8 max-w-5xl">
    <div class="flex gap-2">
      <div class="flex-1">
        <Label
          for="itemPrice"
          :value="'Harga Barang: ' + RupiahFormat(dataPawn.itemPrice)"
        />
        <Input
          class="mt-1"
          id="itemPrice"
          type="text"
          v-model="dataPawn.itemPrice"
          @keyup="dataPawn.itemPrice * 0.6 < dataPawn.pawnPrice && (dataPawn.pawnPrice = dataPawn.itemPrice * 0.6)"
        />
      </div>

      <div class="flex-1">
        <div class="flex justify-between">
          <Label
            for="PawnPrice"
            :value="'Harga Gadai: ' + RupiahFormat(dataPawn.pawnPrice)"
          />
          <Label
            for="PawnPrice"
            :value="'Maks ' + RupiahFormat(dataPawn.itemPrice * 0.6)"
          />
        </div>
        <Input
          class="mt-1"
          id="PawnPrice"
          type="text"
          v-model="dataPawn.pawnPrice"
          @keyup="
            dataPawn.itemPrice * 0.6 < dataPawn.pawnPrice &&
              (dataPawn.pawnPrice = dataPawn.itemPrice * 0.6)
          "
        />
      </div>
    </div>

    <div class="mt-4 w-1/2">
      <Label for="tempo" :value="'Tempo: ' + dataPawn.tempo + ' hari'" />
      <Input class="mt-1" id="tempo" type="date" @change="onChangeDeadlineDate()" v-model="dataPawn.deadlineDate" />
    </div>

    <div class="mt-4 flex gap-2">
      <div class="flex-1">
        <Label
          for="interest"
          :value="'Bunga: ' + interest + '%'"
        />
        <Input
          class="mt-1"
          id="interest"
          type="text"
          v-model="interest"
        />
      </div>

      <div class="flex-1">
        <Label
          for="totalIntrest"
          :value="'Total Bunga: ' + interest * dataPawn.tempo + '%'"
        />
        <Input
          class="mt-1"
          id="totalIntrest"
          type="text"
          :modelValue="interest * dataPawn.tempo"
          disabled
        />
      </div>
    </div>

    <div class="mt-4 w-1/2">
      <Label
        class="font-bold"
        :value="'Total Harga Yang Harus Di Kembalikan: ' + RupiahFormat(TotalPrice)"
      />
    </div>
  </div>

  <div class="w-48 mt-8">
    <Button @click="onClickSave">Ubah</Button>
  </div>
</template>
