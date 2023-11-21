<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import mapValues from 'lodash/mapValues'
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLS, GetURLS } from '@/Config';
import { WeightFormat } from '@/Components/utils/Number';
import { MoreDetail } from '@/Components/svg/icon';
import Pagination from '@/Components/AddOn/Pagination.vue';
import CustomDropdown from '@/Components/Button/CustomDropdown.vue';
import { TextSmall } from '@/Components/Text';
import Input from '@/Components/Input';
import { DateForPage } from '@/Components/utils/Date';

export default {
  layout: NavbarLayout,

  props: {
    allBookKeepingHeaderBasedOnShelf: Object,
    shelf: Object
  },

  data() {
    return {
      URLS,
      TABLE_TITLE: [
        'Berat Timbangan',
        'Berat Kalkulasi',
        'Tanggal Dari',
        'Tanggal Sampai',
        'Aksi',
      ],
      dataFilter: {
        fromFromDate: '',
        toFromDate: '',
        fromToDate: '',
        toToDate: '',
      },
    }
  },

  components: {
    Head,
    Link,
    MoreDetail,
    Pagination,
    CustomDropdown,
    TextSmall,
    Input,
  },

  methods: {
    GetURLS,
    WeightFormat,
    DateForPage,
    DataReset() {
      this.dataFilter = mapValues(this.dataFilter, () => '');
    },
  },

  watch: {
    dataFilter: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get(GetURLS('BookKeeping', this.shelf.id), pickBy(this.dataFilter), { preserveState: true })
      }, 150),
    },
  },
}
</script>

<template>
  <Head :title="URLS.BookKeeping.title + ' ' + shelf.name" />

  <div class="text-2xl">{{ URLS.BookKeeping.title + " " + shelf.name}}</div>

  <div class="flex gap-2 mt-8">
    <div class="w-48">
      <custom-dropdown>
        <template #title>Filter</template>
        <template #content>
          <div class="mt-2">
            <span class="py-2 font-bold">Tanggal Dari</span>
            <div class="flex gap-2 content-between py-2">
              <Input class="mt-1" type="date" placeholder="Harga Minimum" @keyup="Submit" @change="Submit">
                {{ DateForPage(dataFilter.fromFromDate) }}
              </Input>
              <span class="my-auto">-</span>
              <Input class="mt-1" type="date" placeholder="Harga Maksimum" @keyup="Submit" v-model="dataFilter.fromToDate" @change="Submit" />
            </div>
          </div>
          <div class="mt-2">
            <span class="py-2 font-bold">Tanggal Sampai</span>
            <div class="flex gap-2 content-between py-2">
              <Input class="mt-1" type="date" placeholder="Harga Minimum" @keyup="Submit" v-model="dataFilter.toFromDate" @change="Submit" />
              <span class="my-auto">-</span>
              <Input class="mt-1" type="date" placeholder="Harga Maksimum" @keyup="Submit" v-model="dataFilter.toToDate" @change="Submit" />
            </div>
          </div>
        </template>
      </custom-dropdown>
    </div>
    <div class="flex">
      <text-small color="text-red-700" @click="DataReset">Reset</text-small>
    </div>
  </div>

  <table class="mt-8">
    <tr>
      <th v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
    </tr>
    <tr v-for="(data) in allBookKeepingHeaderBasedOnShelf.data" :key="data.id">
      <td>{{ WeightFormat(data.scale_weight) }}</td>
      <td>{{ WeightFormat(data.calculation_weight) }}</td>
      <td>{{ data.from_date }}</td>
      <td>{{ data.to_date }}</td>
      <td><Link :href="GetURLS('BookKeepingDetail', data.id)"><MoreDetail class="cursor-pointer" /></Link></td>
    </tr>
  </table>
  <pagination class="mt-2" :links="allBookKeepingHeaderBasedOnShelf.links" />
</template>
