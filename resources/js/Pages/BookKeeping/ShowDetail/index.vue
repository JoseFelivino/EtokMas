<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { GetTitle, isGreenOrRedColor, URLS } from '@/Config';
import { RupiahFormat } from '@/Components/utils/Number';
import { CountTotalBookKeeping } from '../config'
import Pagination from '@/Components/AddOn/Pagination.vue';
import { DateForPage } from '@/Components/utils/Date';

export default {
    layout: NavbarLayout,

    props: {
      allBookKeepingDetailBasedOnHeader: Object,
      bookKeepingHeader: Object,
    },

    data() {
      return {
        URLS,
        titlePage: 'Detail Pembukuan ' + this.bookKeepingHeader.shelf.name,
        totalBookKeeping: {
          qty: Number,
          weight: Number,
          price: Number,
        },
      }
    },

    components: {
        Head,
        Pagination,
    },

    methods: {
      RupiahFormat,
      DateForPage,
      isGreenOrRedColor,
    },

    mounted() {
      const total = CountTotalBookKeeping(this.allBookKeepingDetailBasedOnHeader.data);
      this.totalBookKeeping.qty = total.totalQty;
      this.totalBookKeeping.weight = total.totalWeight;
      this.totalBookKeeping.price = total.totalPrice;
    },
}
</script>

<template>
  <Head :title="titlePage" />
  <div class="text-2xl">{{ titlePage }}</div>

  <div class="flex flex-col gap-2 mt-8">
    <li class="flex gap-2">
      <span>Tanggal</span>
      <span class="font-bold">: {{ DateForPage(bookKeepingHeader.from_date) }}  ->  {{ DateForPage(bookKeepingHeader.to_date) }}</span>
    </li>
    <li class="flex gap-2">
      <span>Berat Timbangan</span>
      <span class="font-bold">: {{ bookKeepingHeader.scale_weight }}</span>
    </li>
  </div>
  <br/>
  <br/>
  <h2 class="text-xl">Keluar Masuk Emas</h2>
  <br/>
  <table>
    <tr>
      <th>No</th>
      <th>Nama Penjaga</th>
      <th>Nama Emas</th>
      <th>Jumlah</th>
      <th>Berat</th>
      <th>Harga</th>
    </tr>
    <tr :class="isGreenOrRedColor(data.isAddition)" v-for="(data, index) in allBookKeepingDetailBasedOnHeader.data" :key="data.id">
      <td>{{ index + 1 }}</td>
      <td>{{ data.gold.user.name }}</td>
      <td>{{ data.gold.name }}</td>
      <td>{{ data.quantity }}</td>
      <td>{{ data.gold.weight }}</td>
      <td>{{ RupiahFormat(data.gold.price) }}</td>
    </tr>
    <tr class="font-bold">
      <td>Total</td>
      <td>-</td>
      <td>-</td>
      <td>{{ totalBookKeeping.qty }}</td>
      <td>{{ totalBookKeeping.weight }}</td>
      <td>{{ RupiahFormat(totalBookKeeping.price) }}</td>
    </tr>
  </table>
  <pagination class="mt-2" :links="allBookKeepingDetailBasedOnHeader.links" />
</template>
