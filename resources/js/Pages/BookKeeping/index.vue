<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLS, GetURLS } from '@/Config';
import { Add as AddIcon, MoreDetail, MoreDetailOff } from '@/Components/svg/icon';
import { Button } from '@/Components/Button/Link';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import Pagination from '@/Components/AddOn/Pagination.vue';
import { TextContainerDanger } from '@/Components/Text';
import { WeightFormat } from '@/Components/utils/Number';
import { DateForPage } from '@/Components/utils/Date';

export default {
    layout: NavbarLayout,

    props: {
      allBookKeepingHeaderBasedOnShelf: Object,
    },

    data() {
      return {
        URLS,
        isModalOpen: false,
        TableData: [],
        TABLE_TITLE: [
          'Nama Rak',
          'Berat Timbangan',
          'Dari Tanggal',
          'Sampai Tanggal',
          'Aksi',
        ],
      };
    },

    components: {
      Head,
      Link,
      Button,
      AddIcon,
      MoreDetail,
      MoreDetailOff,
      FlashSuccessAndErrorMessage,
      Pagination,
      TextContainerDanger,
    },

    methods: {
      GetURLS,
      WeightFormat,
      DateForPage,
    }
}
</script>

<template>
  <Head :title="URLS.BookKeeping.title" />
  
  <div class="flex items-center gap-2">
    <div class="text-2xl">{{ URLS.BookKeeping.title }}</div>
    <FlashSuccessAndErrorMessage />
  </div>

  <div class="mt-8">
    <text-container-danger text="Tidak ada data Pembukuan" v-if="!allBookKeepingHeaderBasedOnShelf.length" />
    <table v-else>
      <tr>
        <th :class="index !== TABLE_TITLE.length-1 && 'min-w-48'" v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
      </tr>
      <tr v-for="data in allBookKeepingHeaderBasedOnShelf" :key="data.id">
        <td>{{ data.name }}</td>
        <td>{{ data.book_keeping_headers.length !== 0 ? WeightFormat(data.book_keeping_headers[data.book_keeping_headers.length - 1].scale_weight) : '-' }}</td>
        <td>{{ data.book_keeping_headers.length !== 0 ? DateForPage(data.book_keeping_headers[data.book_keeping_headers.length - 1].from_date) : '-' }}</td>
        <td>{{ data.book_keeping_headers.length !== 0 ? DateForPage(data.book_keeping_headers[data.book_keeping_headers.length - 1].to_date) : '-' }}</td>
        <td :class="[(data.book_keeping_headers.length !== 0) && 'flex', 'flex gap-2']">
          <div v-if="data.book_keeping_headers.length !== 0">
            <Link class="cursor-pointer" :href="GetURLS('BookKeeping', data.id)">
              <MoreDetail />
            </Link>
          </div>
          <MoreDetailOff class="cursor-not-allowed" v-else />
          <Link class="cursor-pointer" :href="GetURLS('BookKeeping', data.id, 'add')">
            <AddIcon />
          </Link>
        </td>
      </tr>
    </table>
  </div>
  <!-- <div class="mt-2">
    <pagination :links="allBookKeepingHeaderBasedOnShelf.data" />
  </div> -->
</template>
