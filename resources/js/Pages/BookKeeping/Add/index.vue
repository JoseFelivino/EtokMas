<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { GetURLS, GetTitle, isGreenOrRedColor } from '@/Config';
import Input from "@/Components/Input.vue";
import { Button } from "@/Components/Button/Link";
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import { NumberFormat, RupiahFormat } from '@/Components/utils/Number';
import { DateForPage } from '@/Components/utils/Date';
import { CountTotalBookKeeping, getBookKeepingDetailsIds  } from '../config'
import { TextValidationError } from '@/Components/Text';

export default {
    layout: NavbarLayout,

    props: {
      shelf: Object,
      calculatedWeight: Float32Array,
      bookKeepingDetails: Object,
      allStockInShelf: Object,
      fromDate: String,
      toDate: String,
      totalPriceStock: Number,
      totalQuantityStock: Number,
      totalWeightStock: Number,
      errors: Object,
    },

    data() {
      return {
        titlePage: GetTitle('BookKeeping') + ' Rak ' + this.shelf.name,
        totalBookKeeping: {
          qty: Number,
          weight: Number,
          price: Number,
        },
        form: this.$inertia.form({
          shelfId: this.shelf.id,
          calculatedWeight: this.calculatedWeight,
          scaledWeight: '',
          bookKeepingDetailIds: getBookKeepingDetailsIds(this.bookKeepingDetails),
          fromDate: this.fromDate,
          toDate: this.toDate,
        }),
        TABLE_TITLE: [
          'Nama Emas',
          'Karyawan Yang Bertanggung jawab',
          'Jumlah',
          'Berat',
          'Harga',
          'Total Berat',
          'Total Harga',
        ],
      }
    },

    components: {
        Head,
        Input,
        Button,
        TextValidationError,
        FlashSuccessAndErrorMessage,
    },

    methods: {
      DateForPage,
      NumberFormat,
      RupiahFormat,
      isGreenOrRedColor,
      SubmitEvent() {
        this.form.post(GetURLS('BookKeeping'), {
          onSuccess: () => this.form.reset()
        })
      },
    },

    mounted() {
      const total = CountTotalBookKeeping(this.bookKeepingDetails);
      this.totalBookKeeping.qty = total.totalQty;
      this.totalBookKeeping.weight = total.totalWeight;
      this.totalBookKeeping.price = total.totalPrice;
    },
}
</script>

<template>
  <Head :title="titlePage" />

  <div class="text-2xl">{{ titlePage }}</div>

  <form class="mt-8 max-w-screen-sm" @submit.prevent="SubmitEvent">
    <div class="grid grid-cols-2 h-10">
      <label class="w-72 font-bold my-auto" for="qty">Jumlah Stok</label>
      <span class="my-auto">{{ totalQuantityStock }}</span>
    </div>
    <div class="grid grid-cols-2 h-10 mt-2">
      <label class="w-72 font-bold my-auto">Berat Kalkulasi</label>
      <span class="my-auto">{{ NumberFormat(calculatedWeight) + ' g' }}</span>
    </div>
    <div class="grid grid-cols-2 h-10 mt-2">
      <label class="w-72 font-bold my-auto">Tanggal Pembukuan Terakhir</label>
      <span class="my-auto">{{ DateForPage(bookKeepingDetails[0].updated_at) }}</span>
    </div>
    <div class="mt-8">
      <label class="block font-bold my-auto" for="fromDate">Barang Saat Ini Di {{this.shelf.name}}</label>
      <label class="block text-sm my-auto">Tanggal : {{ toDate }}</label>
      <table class="mt-2">
        <tr>
          <th v-for="(data, index) in TABLE_TITLE" :key="index">
            {{ data }}
          </th>
        </tr>
        <tr v-for="data in allStockInShelf" :key="data.id">
          <td>{{ data.gold.name }}</td>
          <td>{{ data.gold.user.name }}</td>
          <td>{{ data.quantity }}</td>
          <td>{{ data.gold.weight }}</td>
          <td>{{ RupiahFormat(data.gold.price) }}</td>
          <td>{{ data.totalWeight }}</td>
          <td>{{ RupiahFormat(data.totalPrice) }}</td>
        </tr>
        <tr class="font-bold">
          <td>Total</td>
          <td> - </td>
          <td>{{ totalQuantityStock }}</td>
          <td> - </td>
          <td> - </td>
          <td>{{ totalWeightStock }}</td>
          <td>{{ RupiahFormat(totalPriceStock) }}</td>
        </tr>
      </table>
    </div>
    <div class="mt-8">
      <label class="block font-bold my-auto" for="fromDate">Riwayat Keluar Masuk Emas</label>
      <label class="block text-sm my-auto">Rentang tanggal : {{ fromDate }} - {{ toDate }}</label>
      <table class="mt-2">
        <tr>
          <th v-for="(data, index) in TABLE_TITLE" :key="index">
            {{ data }}
          </th>
        </tr>
        <tr :class="isGreenOrRedColor(data.isAddition)" v-for="data in bookKeepingDetails" :key="data.id">
          <td>{{ data.gold.name }}</td>
          <td>{{ data.gold.user.name }}</td>
          <td>{{ data.quantity }}</td>
          <td>{{ data.gold.weight }}</td>
          <td>{{ RupiahFormat(data.gold.price) }}</td>
          <td>{{ data.totalWeight }}</td>
          <td>{{ RupiahFormat(data.totalPrice) }}</td>
        </tr>
        <tr class="font-bold">
          <td>Total</td>
          <td> - </td>
          <td>{{ totalBookKeeping.qty }}</td>
          <td> - </td>
          <td> - </td>
          <td>{{ totalBookKeeping.weight }}</td>
          <td>{{ RupiahFormat(totalBookKeeping.price) }}</td>
        </tr>
      </table>
    </div>
    <div class="grid grid-cols-2 h-10 mt-8">
      <label class="w-72 font-bold my-auto" for="scales">Timbangan</label>
      <div class="flex flex-col">
        <Input
          type="text"
          id="scales"
          placeholder="Timbangan"
          v-model="form.scaledWeight"
          autofocus
        />
        <text-validation-error error="scaledWeight" />
      </div>
    </div>
    <Button class="mt-8" @click="SubmitEvent">Simpan</Button>
    <FlashSuccessAndErrorMessage class="mt-8" />
  </form>
</template>
