<script>
import { Link } from '@inertiajs/inertia-vue3';
import { Modal } from '../';
import { RupiahFormat } from '@/Components/utils/Number';
import { GetURLS } from '@/Config';

export default {
  props: {
    TransactionHeaders: {
      type: Object,
      required: true,
    },
    TransactionHeaders: {
      type: Object,
      required: true,
    },
  },
  
  data() {
    return {
      TABLE_TITLE: [
        'No.',
        'Nama Emas',
        'Berat Emas',
        'Jumlah',
        'Nama Rak',
        'Kategori Emas',
        'Karat',
        'Harga',
      ],
      isModalOpen: false,
    }
  },

  components: {
    Link,
    Modal,
  },

  methods: {
    GetURLS,
    RupiahFormat,
    OpenModal() {
      this.isModalOpen = true;
    },
  },
}
</script>

<template>
  <modal v-if="isModalOpen" @close="isModalOpen = false">
    <div class="flex gap-4">
      <div class="font-bold">
        <div>Nama Customer</div>
        <div>Tanggal Transaksi</div>
        <div>Total Biaya Transaksi</div>
      </div>
      <div>
        <div>: {{ TransactionHeaders.customer.name }}</div>
        <div>: {{ TransactionHeaders.created_at }}</div>
        <div>: {{ RupiahFormat(TransactionHeaders.totalPriceGold) }}</div>
      </div>
    </div>
    <table class="text-base mt-4">
      <tr>
        <th v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
      </tr>
      <tr
        v-for="(data, index) in TransactionHeaders.transaction_details"
        :key="index"
      >
        <td>{{ index + 1 }}</td>
        <td><Link class="text-blue-700" :href="GetURLS('Stock', data.gold.id)"><span class="cursor-pointer">{{ data.gold.name }}</span></Link></td>
        <td>{{ data.gold.weight }}</td>
        <td>{{ data.quantity }}</td>
        <td>{{ data.gold.shelf.name }}</td>
        <td>
          <span v-if="!data.gold.categories.length">-</span>
          <ul v-else>
            <li v-for="data in data.gold.categories" :key="data.id">
              {{data.name}}
            </li>
          </ul>
        </td>
        <td>{{ data.gold.gold_carat_category.carat }}</td>
        <td>{{ RupiahFormat(data.price) }}</td>
      </tr>
    </table>
  </modal>
</template>