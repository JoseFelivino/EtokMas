<script>
import { Head } from '@inertiajs/inertia-vue3';
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import mapValues from 'lodash/mapValues'
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLS, GetTitle, GetURLS } from '@/Config';
import { DateForPage } from '@/Components/utils/Date';
import { RupiahFormat } from '@/Components/utils/Number';
import Pagination from '@/Components/AddOn/Pagination.vue';
import { MoreDetail } from '@/Components/svg/icon';
import { TransactionHistoryModal } from '@/Components/Modal';
import { TextContainerDanger, TextSmall } from '@/Components/Text';
import Input from '@/Components/Input';
import CustomDropdown from '@/Components/Button/CustomDropdown.vue';

export default {
  layout: NavbarLayout,

  props: {
    allTransactionHeader: Object,
  },

  data() {
    return {
      URLS,
      titlePage: GetTitle('TransactionHistory'),
      TABLE_TITLE: [
        'Nama Penjaga',
        'Nama Customer',
        'Tanggal Transaksi',
        'Total Biaya Transaksi',
        'Aksi',
      ],
      dataFilter: {
        keyword: '',
        fromDate: '',
        toDate: '',
      },
    }
  },

  components: {
    Head,
    Input,
    Pagination,
    MoreDetail,
    TransactionHistoryModal,
    TextContainerDanger,
    TextSmall,
    CustomDropdown,
  },

  methods: {
    DateForPage,
    RupiahFormat,
    DataReset() {
      this.dataFilter = mapValues(this.dataFilter, () => '');
    },
  },

  watch: {
    dataFilter: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get(GetURLS('TransactionHistory'), pickBy(this.dataFilter), { preserveState: true })
      }, 150),
    },
  },
}
</script>

<template>
  <Head :title="titlePage" />

  <div class="text-2xl">{{ titlePage }}</div>

  <div class="flex gap-2 mt-8">
    <div class="w-96">
      <Input type="text" class="block w-96" placeholder="Search" v-model="dataFilter.keyword" />
    </div>
    <div class="w-48">
      <custom-dropdown>
        <template #title>Filter</template>
        <template #content>
          <div class="mt-2">
            <span class="py-2 font-bold">Tanggal Transaksi</span>
            <div class="flex gap-2 content-between py-2">
              <Input class="mt-1" type="date" placeholder="Harga Minimum" @keyup="Submit" v-model="dataFilter.fromDate" @change="Submit" />
              <span class="my-auto">-</span>
              <Input class="mt-1" type="date" placeholder="Harga Maksimum" @keyup="Submit" v-model="dataFilter.toDate" @change="Submit" />
            </div>
          </div>
        </template>
      </custom-dropdown>
    </div>
    <div class="flex">
      <text-small color="text-red-700" @click="DataReset">Reset</text-small>
    </div>
  </div>

  <div class="mt-8">
    <text-container-danger text="Tidak ada Riwayat Transaksi Penjualan" v-if="!allTransactionHeader.data.length" />
    <table v-else>
      <tr>
        <th v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
      </tr>
      <tr v-for="data in allTransactionHeader.data" :key="data.id">
        <td>{{ data.user.name }}</td>
        <td>{{ data.customer.name }}</td>
        <td>{{ DateForPage(data.created_at) }}</td>
        <td>{{ RupiahFormat(data.totalPriceGold) }}</td>
        <td class="flex">
          <MoreDetail class="cursor-pointer" @click.prevent="$refs['transactionHistoryModal' + data.id].OpenModal()" />
        </td>
        <transaction-history-modal :TransactionHeaders="data" :ref="'transactionHistoryModal' + data.id"/>
      </tr>
    </table>
  </div>

  <div class="mt-8">
    <pagination :links="allTransactionHeader.links" />
  </div>

</template>
