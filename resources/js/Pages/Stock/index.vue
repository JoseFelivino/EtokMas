<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import mapValues from 'lodash/mapValues'
import { GetURLS, GetTitle } from '@/Config';
import LoadingTemplateSquare from '@/Components/svg/loadingTemplate-one.vue';
import InputBox from '@/Components/Input.vue';
import Button from '@/Components/Button/Link/Button.vue';
import CustomDropdown from '@/Components/Button/CustomDropdown.vue';
import Checkbox from '@/Components/Button/Checkbox.vue';
import { RupiahFormat } from '@/Components/utils/Number'
import NavbarLayout from '@/Layouts/Navbar.vue'
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import { TextSmall } from '@/Components/Text';
import { Pagination } from '@/Components/AddOn';

export default {
  layout: NavbarLayout,

  props: {
    allItemsInStock: Object,
    allGoldCaratCategory: Object,
    allCategory: Object,
    allShelf:Object,
    lowestPriceGoldValueInStock: Number,
    highestPriceGoldValueInStock: Number,
    lightestGoldValueInStock: Boolean,
    heaviestGoldValueInStock: Boolean,
  },

  data() {
    return {
      titlePage: GetTitle('Stock'),
      dataFilter: {
        stockCategories: [],
        searchStockKeyword: '',
        caratId: '',
        shelfId: '',
        minPrice: '',
        maxPrice: '',
        minWeight: '',
        maxWeight: '',
      }
    }
  },

  components: {
    LoadingTemplateSquare,
    Head,
    Link,
    InputBox,
    Button,
    CustomDropdown,
    Checkbox,
    FlashSuccessAndErrorMessage,
    Pagination,
    TextSmall,
  },

  methods:{
    GetURLS,
    RupiahFormat,
    dataReset() {
      this.dataFilter = mapValues(this.dataFilter, () => '');
      this.dataFilter.stockCategories = [];
    }
  },

  watch: {
    dataFilter: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get(GetURLS('Stock'), pickBy(this.dataFilter), { preserveState: true })
      }, 150),
  },
  },
}
</script>

<template>
  <Head :title="titlePage" />

  <h1 class="text-2xl">{{ titlePage }}</h1>
  <FlashSuccessAndErrorMessage class="mt-8" />
  <div class="flex justify-between items-center mt-8">
    <div class="flex gap-2">
      <div class="w-96">
          <InputBox type="text" class="block w-96" placeholder="Search" v-model="dataFilter.searchStockKeyword" />
      </div>
      <div class="w-48">
        <custom-dropdown>
          <template #title>Filter</template>
          <template #content>
            <div><span class="py-2 font-bold">Kategori</span></div>
            <div class="py-2" v-for="data in allCategory" :key="data.id">
                <input type="checkbox" :id="data.id" :value="data.name" v-model="dataFilter.stockCategories"/>
                <label class="ml-2" :for="data.id">{{data.name}}</label>
            </div>
            <hr class="my-2">

            <div>
              <span class="py-2 font-bold block">Rak</span>
              <select class="w-full" name="shelf_id" id="rack" v-model="dataFilter.shelfId" >
                <option selected="selected" value="">Pilih rak</option>
                <option v-for="data in allShelf" :key="data.id" :value="data.id">
                  {{ data.name }}
                </option>
              </select>
            </div>
            <hr class="my-2">

            <div>
              <span class="py-2 font-bold block">Karat</span>
              <select class="w-full" name="shelf_id" id="rack" v-model="dataFilter.caratId" >
                <option selected="selected" value="">Pilih karat</option>
                <option v-for="data in allGoldCaratCategory" :key="data.id" :value="data.id">
                  {{ data.carat }}
                </option>
              </select>  
            </div>
            <hr class="my-2">

            <span class="py-2 font-bold">Harga</span>
            <div class="flex content-between py-2">
                <div class="flex flex-col text-xs">
                    <span>Harga Terendah: {{RupiahFormat(lowestPriceGoldValueInStock)}}</span>
                    <InputBox class="mt-1" type="text" placeholder="Harga Minimum" v-model="dataFilter.minPrice" />
                </div>
                <div class="flex flex-col text-xs ml-2">
                    <span>Harga Tertinggi: {{RupiahFormat(highestPriceGoldValueInStock)}}</span>
                    <InputBox class="mt-1" type="text" placeholder="Harga Maksimum" v-model="dataFilter.maxPrice" />
                </div>
            </div>
            <hr class="my-2">
            <span class="py-2 font-bold">Berat</span>
            <div class="flex content-between py-2">
              <div class="flex flex-col text-xs">
                <span>Berat Terendah: {{lightestGoldValueInStock}}</span>
                <InputBox class="mt-1" type="text" placeholder="Berat Minimum" v-model="dataFilter.minWeight" />
              </div>
              <div class="flex flex-col text-xs ml-2">
                <span>Berat Tertinggi: {{heaviestGoldValueInStock}}</span>
                <InputBox class="mt-1" type="text" placeholder="Berat Maksimum" v-model="dataFilter.maxWeight" />
              </div>
            </div>
            </template>
          </custom-dropdown>
        </div>
        <div class="flex items-center" @click="dataReset">
            <text-small color="text-red-700">Reset</text-small>
        </div>
    </div>
    <div class="w-48">
      <Link :href="GetURLS('Stock', null, 'add')">
        <Button>Tambah</Button>
      </Link>
    </div>
  </div>

  <div class="cardContainer mt-8">
    <div class="card max-w-52 transform hover:scale-105" v-for="data in allItemsInStock.data" :key="data.id">
      <Link :href="GetURLS('Stock', data.id)">
        <div class="imgContainer">
          <img class="w-48 max-h-48" :src="data.gold.img_path">
        </div>
        <div class="p-2">
          <div><span class="title">{{data.gold.name}}</span></div>
          <div class="description"><span>Berat : </span><span>{{data.gold.weight}}</span></div>
          <div class="description"><span>Karat : </span><span>{{data.gold.gold_carat_category.carat}}</span></div>
          <div class="description"><span>jumlah : </span><span>{{data.quantity}}</span></div>
          <div class="description"><span>Harga : </span><span>{{RupiahFormat(data.price)}}</span></div>
        </div>
      </Link>
    </div>
  </div>
  <div class="mt-2">
    <pagination :links="allItemsInStock.links" />
  </div>
</template>
