<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLS, GetAddGoldCarat, GetURLSEditGoldCarat, GetURLSDeleteGoldCarat } from '@/Config';
import { RupiahFormat } from '@/Components/utils/Number';
import { Edit, Delete } from '@/Components/svg/icon';
import { Button } from '@/Components/Button/Link';
import { TextContainerDanger } from '@/Components/Text';
import FlashSuccessAndErrorMessageVue from '@/Components/FlashSuccessAndErrorMessage.vue';

const { url: addGoldCaratURL } = GetAddGoldCarat();

export default {
    layout: NavbarLayout,

    props: {
        allGoldCaratCategory: Object,
    },

    data() {
      return {
        URLS,
        addGoldCaratURL,
        TABLE_TITLE: [
          'Karat',
          'Harga',
          'Biaya/Potongan',
          'Aksi',
        ],
      }
    },

    components: {
        Head,
        Link,
        Button,
        Edit,
        Delete,
        TextContainerDanger,
        FlashSuccessAndErrorMessageVue,
    },

    methods: {
      GetURLSEditGoldCarat,
      GetURLSDeleteGoldCarat,
      RupiahFormat,
    }
}
</script>

<template>
  <Head :title="URLS.GoldCarat.title" />


  <div class="flex gap-2 mt-8 items-center">
    <div class="text-2xl">{{ URLS.GoldCarat.title }}</div>
    <FlashSuccessAndErrorMessageVue />
  </div>

  <div class="mt-8 w-36">
    <Link :href="addGoldCaratURL"><Button>Tambah</Button></Link>
  </div>

  <div class="mt-8">
    <text-container-danger text="Tidak ada data Karat Emas" v-if="!allGoldCaratCategory.length" />
    <table v-else>
      <tr>
        <th :class="index !== TABLE_TITLE.length-1 && 'min-w-48'" v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
      </tr>
      <tr v-for="data in allGoldCaratCategory" :key="data.id">
        <td>{{ data.carat }}</td>
        <td>{{ RupiahFormat(data.price) }}</td>
        <td>{{ RupiahFormat(data.fee) }}</td>
        <td class="grid grid-cols-2 gap-2">
          <Link :href="GetURLSEditGoldCarat(data.id)" as="button"><Edit /></Link>
          <Link :href="GetURLSDeleteGoldCarat(data.id)" method="delete" as="button"><Delete /></Link>
        </td>
      </tr>
    </table>
  </div>
</template>
