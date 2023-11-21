<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLSub, GetURLSEditStock, GetURLSDeleteStock, IsAdmin } from '@/Config/index';
import { Edit, Delete } from '@/Components/svg/icon';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import { RupiahFormat } from '@/Components/utils/Number';

export default {
  props: {
    stock: Object,
    allGoldCaratCategory: Object,
    allGoldCategory: Object,
    allShelf: Object,
  },

  layout: NavbarLayout,

  data() {
    return {
      URLSub,
      category_id: [],
      form: this.$inertia.form({
        name: this.stock.gold.name,
        weight: this.stock.gold.weight,
        quantity: this.stock.quantity,
        image: this.stock.gold.img_path,
        category_id: [],
        shelf_id: this.stock.gold.shelf_id,
        gold_carat_category_id:
          this.stock.gold.gold_carat_category.id,
      }),
    }
  },

  components: {
    Head,
    Link,
    Edit,
    Delete,
    FlashSuccessAndErrorMessage
  },

  methods: {
    IsAdmin,
    GetURLSEditStock,
    RupiahFormat,
    destroy() {
      if(confirm('Apakah anda yakin ingin menghapus emas ini?')){
        this.$inertia.delete(GetURLSDeleteStock(this.stock.id))
      }
    }
  },

  mounted() {
    this.stock.gold.categories.forEach(i => {
      this.category_id.push(i.name);
    });
  }
}

</script>
<template>
  <Head :title="URLSub.showStock.title" />

  <div class="text-2xl">{{ URLSub.showStock.title }}</div>
  <FlashSuccessAndErrorMessage class="mt-8" />

  <div class="flex gap-8 max-w-5xl mt-8">
    <div class="max-h-80 max-w-xs overflow-hidden rounded-lg">
      <img :src="stock.gold.img_path" alt="" />
    </div>
    <div class="flex flex-col gap-4 max-w-screen-sm">
      <div class="flex flex-col gap-2 font-bold">
        <label class="w-72 my-auto text-xl">{{ stock.gold.name }}</label>
        <label class="w-72 my-auto">{{ RupiahFormat(stock.gold.price) }}</label>
      </div>
      <div class="mt-4">
        <li class="grid grid-cols-2">
          <label class="w-72 my-auto" for="weight">Pembuat / Terakhir Ubah</label>
          <label class="w-72 my-auto">: {{ stock.gold.user.name }}</label>
        </li>
        <li class="grid grid-cols-2">
          <label class="w-72 my-auto" for="weight">Berat</label>
          <label class="w-72 my-auto">: {{ stock.gold.weight }} gram</label>
        </li>
        <li class="grid grid-cols-2">
          <label class="w-72 my-auto" for="total">Jumlah</label>
          <label class="w-72 my-auto">: {{ stock.quantity }}</label>
        </li>
        <li class="grid grid-cols-2">
          <label class="w-72" for="category">Kategori</label>
          <ul>
            <li v-for="data in category_id" :key="data">: {{ data }}</li>
          </ul>
        </li>
        <li class="grid grid-cols-2">
          <label class="w-72 my-auto" for="rack">Rak</label>
          <label class="w-72 my-auto">: {{ stock.gold.shelf.name}}</label>
        </li>
        <li class="grid grid-cols-2">
          <label class="w-72 my-auto" for="carat">Karat</label>
          <label class="w-72 my-auto">: {{ stock.gold.gold_carat_category.carat}}</label>
        </li>
      </div>
      
      <div class="flex gap-2 mt-4">
        <Link :href="GetURLSEditStock(stock.id)"><Edit /></Link>
        <button type="button" @click="destroy" v-if="IsAdmin($page.props.auth.user.role_id)"><Delete /></button>
      </div>
    </div>
  </div>
</template>
