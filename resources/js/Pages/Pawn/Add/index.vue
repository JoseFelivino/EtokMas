<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import NavbarLayout from "@/Layouts/Navbar.vue";
import { RupiahFormat } from "@/Components/utils/Number";
import Label from "@/Components/Label.vue";
import InputBox from "@/Components/Input.vue";
import Button from '@/Components/Button/Link/Button.vue';
import { GetURLS } from '@/Config';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage.vue';
import { Modal } from '@/Components/Modal';
import GetCustomerModal from '@/Components/Modal/Content/GetCustomerModal.vue';
import { TextContainerPrimary, TextValidationError } from '@/Components/Text';

export default {
  layout: NavbarLayout,

  components: {
    Head,
    Link,
    Label,
    InputBox,
    Button,
    Modal,
    FlashSuccessAndErrorMessage,
    TextValidationError,
    TextContainerPrimary,
    GetCustomerModal,
  },

  data() {
    return {
      Customers: [],
      customer: {
        id: '',
        name: '',
      },
      TABLE_TITLE_CUSTOMER: [
        'Nama',
        'Email',
        'Nomor Telepon',
        'Tanggal Lahir',
      ],
      model: {
        customerName: '',
        itemPrice: 0,
        pawnPrice: 0,
        tempo: 0,
        interestTotal: 0.2,
        totalPrice: 0,
        deadlineDate: ""
      },
      modelCustomer: {
        name: '',
      },
      form: this.$inertia.form({
        customerId: Number,
        pawnPrice: Number,
        deadlineDate: String,
        interestTotal: Number,
        totalPrice: Number,
        itemPrice: Number
      }),
    };
  },

  methods: {
    GetURLS,
    RupiahFormat,
    getDifferenceBetweenDateString(dateOne, dateTwo) {
      var date1 = new Date(dateOne)
      var date2 = new Date(dateTwo)
      var Difference_In_Time = date2.getTime() - date1.getTime()
      return Difference_In_Time / (1000 * 3600 * 24)
    },
    onChangeDeadlineDate() {
      var diffDate =  Math.ceil(
        this.getDifferenceBetweenDateString(
          new Date().toLocaleString(), 
          this.model.deadlineDate
        )
      )
      if (diffDate < 0) {
        this.model.deadlineDate = new Date().toISOString().slice(0, 10)
        this.model.tempo = 0
      }
      else this.model.tempo = diffDate
    },
    onClickSave() {
      this.form.pawnPrice = this.model.pawnPrice;
      this.form.deadlineDate = this.model.deadlineDate;
      this.form.interestTotal = this.model.interestTotal;
      this.form.totalPrice = this.totalPrice;
      this.form.itemPrice = this.model.itemPrice;

      this.form.post(GetURLS('GoldPawn'), {
        onSuccess: () => this.form.reset()
      })
    },
  },

  computed: {
    totalPrice() {
      const totalInterest = (this.model.interestTotal * this.model.tempo) / 100
      const interestPrice = totalInterest * this.model.pawnPrice
      const price = parseInt(this.model.pawnPrice) + parseInt(interestPrice)
      return price
    },
  },
}
</script>

<template>
  <Head title="Dashboard" />

  <div class="flex gap-2">
    <div class="mt-8 text-2xl">Tambah Gadai</div>
    <flash-success-and-error-message />
  </div>
  
  <div class="flex flex-col w-min gap-2 mt-8">
    <div class="flex gap-2">
      <div class="w-48">
        <Button @click="$refs['getCustomer'].OpenModal()">Cari Pelanggan</Button>
      </div>
      <get-customer-modal ref="getCustomer" v-model:getCustomerId="form.customerId" v-model:getCustomerName="customer.name" />
    </div>
    <text-container-primary>
      <span>Nama Pelanggan : <span class="font-bold">{{ customer.name || 'Belum Memilih Customer' }}</span></span>
    </text-container-primary>
    <text-validation-error error="customerId" />
    <span class="font-bold my-auto">{{ model.customerName }}</span>
  </div>

  <div class="mt-8 max-w-5xl">
    <div class="flex gap-2">
      <div class="flex-1">
        <Label
          for="itemPrice"
          :value="'Harga Barang: ' + RupiahFormat(model.itemPrice)"
        />
        <InputBox
          class="mt-1"
          id="itemPrice"
          type="text"
          v-model="model.itemPrice"
          @keyup="model.itemPrice * 0.6 < model.pawnPrice && (model.pawnPrice = model.itemPrice * 0.6)"
        />
        <text-validation-error error="pawnPrice" />
      </div>

      <div class="flex-1">
        <div class="flex justify-between">
          <Label
            for="PawnPrice"
            :value="'Harga Gadai: ' + RupiahFormat(model.pawnPrice)"
          />
          <Label
            for="PawnPrice"
            :value="'Maks ' + RupiahFormat(model.itemPrice * 0.6)"
          />
        </div>
        <InputBox
          class="mt-1"
          id="PawnPrice"
          type="text"
          v-model="model.pawnPrice"
          @keyup="
            model.itemPrice * 0.6 < model.pawnPrice &&
              (model.pawnPrice = model.itemPrice * 0.6)
          "
        />
      </div>
    </div>

    <div class="mt-4 w-1/2">
      <Label for="tempo" :value="'Tempo: ' + model.tempo + ' hari'" />
      <InputBox class="mt-1" id="tempo" type="date" @change="onChangeDeadlineDate()" v-model="model.deadlineDate" />
      <text-validation-error error="deadlineDate" />
    </div>

    <div class="mt-4 flex gap-2">
      <div class="flex-1">
        <Label
          for="interestTotal"
          :value="'Bunga: ' + model.interestTotal + '%'"
        />
        <InputBox
          class="mt-1"
          id="interestTotal"
          type="text"
          v-model="model.interestTotal"
        />
      </div>

      <div class="flex-1">
        <Label
          for="totalIntrest"
          :value="'Total Bunga: ' + model.interestTotal * model.tempo + '%'"
        />
        <InputBox
          class="mt-1"
          id="totalIntrest"
          type="text"
          :modelValue="model.interestTotal * model.tempo"
          disabled
        />
      </div>
    </div>

    <div class="mt-4 w-1/2">
      <Label
        class="font-bold"
        :value="'Total Harga Yang Harus Di Kembalikan: ' + RupiahFormat(totalPrice)"
      />
      <text-validation-error error="totalPrice" />
    </div>
  </div>

  <div class="w-48 mt-8">
    <Button @click="onClickSave">Simpan</Button>
  </div>
</template>
