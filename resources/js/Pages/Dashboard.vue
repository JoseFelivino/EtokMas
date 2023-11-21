<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { GetURLS, URLS } from "@/Config/index";
import { Navbar } from "@/Layouts";
import { MoreDetail } from "@/Components/svg/icon";
import DynamicCard from "@/Components/DynamicCard.vue";
import { RupiahFormat } from "@/Components/utils/Number";
import Button from "@/Components/Button/Link/Button.vue";
import { Modal } from "@/Components/Modal";
import { TransactionHistoryModal } from '@/Components/Modal';
import { TextContainerDanger } from '@/Components/Text';
import TextSmall from '@/Components/Text/Content/TextSmall.vue';
import { DateForPage } from '@/Components/utils/Date';

export default {
  layout: Navbar,

  props: {
    profit: Number,
    undonePawn: Object,
    donePawn: Object,
    allTransactionHistory: Object,
  },

  data() {
    return {
      URLS,
      TABLE_TITLE_GADAI: [
        "No.",
        "Nama Penjaga",
        "Nama Customer",
        "Nomor Telp",
        "Tanggal Gadai",
        "Batas Pembayaran",
        "Dana Pinjaman",
        "Dana Tebusan",
        "Aksi",
      ],
      TABLE_TITLE_TRANSAKSI: [
        "No.",
        "Nama Penjaga",
        "Nama Customer",
        "Tanggal Transaksi",
        "Total Biaya Transaksi",
        "Aksi",
      ],
      dataTransactionHistory: this.allTransactionHistory[0],
      isOnGoingPawn: false,
      isModalOpen: false,
    };
  },

  components: {
    Head,
    DynamicCard,
    Button,
    Modal,
    Link,
    MoreDetail,
    TransactionHistoryModal,
    TextContainerDanger,
    TextSmall,
  },

  methods: {
    GetURLS,
    DateForPage,
    RupiahFormat,
    toggleModal(dataTransactionHistory) {
      this.isModalOpen = !this.isModalOpen;
      this.dataTransactionHistory = dataTransactionHistory;
    },
  },
};
</script>

<template>
  <Head :title="URLS.Dashboard.title" />

  <div class="flex justify-between">
    <h1 class="text-2xl">{{ URLS.Dashboard.title }}</h1>
    <div class="dropdown h-8">
      <button class="dropbtn to-blue-300">Rentang Waktu</button>
      <div class="dropdown-content transition-opacity">
        <Link href="/dashboard" method="get" :data="{ timestamp: 'hari' }"
          >Harian</Link
        >
        <Link href="/dashboard" method="get" :data="{ timestamp: 'minggu' }"
          >Mingguan</Link
        >
        <Link href="/dashboard" method="get" :data="{ timestamp: 'bulan' }"
          >Bulanan</Link
        >
      </div>
    </div>
  </div>

  <DynamicCard class="mt-8 min-w-300">
    <div class="text-xl">
      Penjualan
      <span class="bold text-blue-700">
        {{
          $page.url === "/dashboard?timestamp=minggu"
            ? "MINGGU"
            : $page.url === "/dashboard?timestamp=bulan"
            ? "BULAN"
            : "HARI"
        }}
      </span>
      ini :<br />
      <div class="mt-4">
        <span class="text-green-700">{{ RupiahFormat(profit) }}</span>
      </div>
    </div>
  </DynamicCard>

  <div>
    <div class="text-xl inline-block mt-8">
      <div class="flex justify-between gap-2">
        <span>Gadai Yang sedang Berlangsung :</span>
        <Link :href="GetURLS('GoldPawn')" :data="{ pawnStatusId: ['2'] }"><text-small color="text-green-700">Lihat Semua</text-small></Link>
      </div>
      <div class="mt-4 text-base">
        <text-container-danger text="Tidak ada Riwayat Transaksi yang sudah selesai" v-if="!undonePawn.length" />
        <table v-else>
          <tr>
            <th v-for="(data, index) in TABLE_TITLE_GADAI" :key="index">
              {{ data }}
            </th>
          </tr>
          <tr v-for="(data, index) in undonePawn" :key="data.id">
            <td>{{ index + 1 }}</td>
            <td>{{ data.user.name }}</td>
            <td>{{ data.customer.name }}</td>
            <td>{{ data.customer.phone_number }}</td>
            <td>{{ DateForPage(data.created_at) }}</td>
            <td>{{ DateForPage(data.deadline_date) }}</td>
            <td>{{ RupiahFormat(data.loan_price) }}</td>
            <td>{{ RupiahFormat(data.return_price) }}</td>
            <td class="flex">
              <MoreDetail class="cursor-pointer" @click="toggleModal(data)" />
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div>
    <div class="text-xl inline-block mt-8">
      <div class="flex justify-between gap-2">
        <span>Gadai Yang sudah selesai :</span>
        <Link :href="GetURLS('GoldPawn')" :data="{ pawnStatusId: ['1'] }"><text-small color="text-green-700">Lihat Semua</text-small></Link>
      </div>
      
      <div class="mt-4 text-base">
        <text-container-danger text="Tidak ada Gadai yang sudah selesai" v-if="!donePawn.length" />
        <table v-else>
          <tr>
            <th v-for="(data, index) in TABLE_TITLE_GADAI" :key="index">
              {{ data }}
            </th>
          </tr>
          <tr v-for="(data, index) in donePawn" :key="data.id">
            <td>{{ index + 1 }}</td>
            <td>{{ data.user.name }}</td>
            <td>{{ data.customer.name }}</td>
            <td>{{ data.customer.phone_number }}</td>
            <td>{{ DateForPage(data.created_at) }}</td>
            <td>{{ DateForPage(data.deadline_date) }}</td>
            <td>{{ RupiahFormat(data.loan_price) }}</td>
            <td>{{ RupiahFormat(data.return_price) }}</td>
            <td class="flex">
              <MoreDetail class="cursor-pointer" @click="toggleModal(data)" />
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div>
    <div class="text-xl inline-block mt-8">
      <div class="flex justify-between gap-2">
        <span>Riwayat Transaksi Penjualan :</span>
        <Link :href="GetURLS('TransactionHistory')"><text-small color="text-green-700">Lihat Semua</text-small></Link>
      </div>
      <div class="mt-4 text-base">
        <text-container-danger text="Tidak ada Riwayat Transaksi yang sudah selesai" v-if="allTransactionHistory.length == 0" />
        <table v-else>
          <tr>
            <th v-for="(data, index) in TABLE_TITLE_TRANSAKSI" :key="index">
              {{ data }}
            </th>
          </tr>
          <tr v-for="(data, index) in allTransactionHistory" :key="data.id">
            <td>{{ index + 1 }}</td>
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
    </div>
  </div>

  <modal @close="toggleModal" v-if="isModalOpen">
      <div class="flex gap-4">
        <div class="font-bold">
          <div>Nama Customer</div>
          <div>Nomor Telp Customer</div>
          <div>Tanggal Gadai</div>
          <div>Batas Pembayaran</div>
          <div>Dana Pinjaman</div>
          <div>Dana Tebusan</div>
          <div>Total Bunga</div>
        </div>
        <div>
          <div>: {{ dataTransactionHistory.customer.name }}</div>
          <div>: {{ dataTransactionHistory.customer.phone_number }}</div>
          <div>: {{ DateForPage(dataTransactionHistory.created_at) }} </div>
          <div>: {{ DateForPage(dataTransactionHistory.deadline_date) }}</div>
          <div>: {{ RupiahFormat(dataTransactionHistory.loan_price) }}</div>
          <div>: {{ RupiahFormat(dataTransactionHistory.return_price) }}</div>
          <div>: {{ dataTransactionHistory.interest_total }}%</div>
        </div>
      </div>
  </modal>
</template>
