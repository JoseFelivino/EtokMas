<script>
import { Head } from "@inertiajs/inertia-vue3";
import NavbarLayout from "@/Layouts/Navbar.vue";
import Button from "@/Components/Button/Link/Button.vue";
import CustomDropdown from "@/Components/Button/CustomDropdown.vue";
import Input from "@/Components/Input.vue";
import { URLSub, GetURLSUpdateStock } from "@/Config/index";
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import FileInput from '@/Components/FileInput'

export default {
  layout: NavbarLayout,

  props: {
    currentItemGold: Object,
    allGoldCaratCategory: Object,
    allGoldCategory: Object,
    allShelf: Object,
  },

  data() {
    return {
      URLSub,
      form: this.$inertia.form({
        _method: 'put',
        name: this.currentItemGold.gold.name,
        weight: this.currentItemGold.gold.weight,
        quantity: this.currentItemGold.quantity,
        image: null,
        category_id: [],
        shelf_id: this.currentItemGold.gold.shelf_id,
        gold_carat_category_id:
          this.currentItemGold.gold.gold_carat_category.id,
      }),
    };
  },

  components: {
    Head,
    Button,
    Input,
    CustomDropdown,
    FlashSuccessAndErrorMessage,
    FileInput
  },

  methods: {
    GetURLSUpdateStock,
    SubmitEvent() {
      this.form.post(GetURLSUpdateStock(this.currentItemGold.id));
    },
  },

  mounted() {
    this.currentItemGold.gold.categories.forEach(i => {
      this.form.category_id.push(i.id);
    });
  }
};
</script>

<template>
  <Head :title="URLSub.editStock.title" />

  <div class="text-2xl">{{ URLSub.editStock.title }}</div>

  <form class="flex gap-8 max-w-5xl mt-8" @submit.prevent="SubmitEvent">
    <div class="max-h-80 max-w-xs overflow-hidden rounded-lg">
      <img :src="currentItemGold.gold.img_path" alt="" />
    </div>
    <div class="max-w-screen-sm">
      <div class="grid grid-cols-2">
        <label class="w-72 font-bold my-auto" for="name">Nama</label>
        <Input
          type="text"
          id="name"
          placeholder="Nama"
          v-model="form.name"
          autocomplete="stock-name"
          autofocus
        />
         <div class="text-red-500" v-if="form.errors.name">{{ form.errors.name }}</div> 
      </div>
      <div class="grid grid-cols-2 mt-4">
        <label class="w-72 font-bold my-auto" for="weight">Berat</label>
        <Input
          type="number"
          id="weight"
          placeholder="Berat"
          step="0.01"
          v-model="form.weight"
        />
        <div class="text-red-500" v-if="form.errors.weight">{{ form.errors.name }}</div> 
      </div>
      <div class="grid grid-cols-2 mt-4">
        <label class="w-72 font-bold my-auto" for="quantity">Jumlah</label>
        <Input
          type="number"
          id="quantity"
          placeholder="Jumlah"
          v-model="form.quantity"
        />
         <div class="text-red-500" v-if="form.errors.quantity">{{ form.errors.quantity }}</div> 
      </div>
      <div class="grid grid-cols-2 mt-4">
        <label class="w-72 font-bold my-auto" for="image">Gambar</label>
        <FileInput
          class="w-72"
          type="file"
          accept="image/*"
          id="image"
          v-model="form.image"
        />
         <div class="text-red-500" v-if="form.errors.image">{{ form.errors.image }}</div> 
      </div>
      <div class="grid grid-cols-2 mt-4">
        <label class="w-72 font-bold my-auto" for="category">Kategori</label>
        <CustomDropdown>
          <template #title>Pilih kategori emas</template>
          <template #content>
            <div class="py-2" v-for="data in allGoldCategory" :key="data.id">
              <input
                type="checkbox"
                :id="data.name"
                :value="data.id"
                v-model="form.category_id"
              />
              <label class="ml-2" :for="data.name">{{ data.name }}</label>
            </div>
          </template>
        </CustomDropdown>
         <div class="text-red-500" v-if="form.errors.category_id">{{ form.errors.category_id }}</div> 
      </div>
      <div class="grid grid-cols-2 mt-4">
        <label class="w-72 font-bold my-auto" for="rack">Rak</label>
        <select name="shelf_id" id="rack" v-model="form.shelf_id">
          <option selected="selected" value="">Pilih rak</option>
          <option v-for="data in allShelf" :key="data.id" :value="data.id">
            {{ data.name }}
          </option>
        </select>
         <div class="text-red-500" v-if="form.errors.shelf_id">{{ form.errors.shelf_id }}</div> 
      </div>
      <div class="grid grid-cols-2 mt-4">
        <label class="w-72 font-bold my-auto" for="carat">Karat</label>
        <select
          name="gold_carat_category_id"
          id="carat"
          v-model="form.gold_carat_category_id"
        >
          <option selected="selected" value="">Pilih karat</option>
          <option
            v-for="data in allGoldCaratCategory"
            :key="data.id"
            :value="data.id"
          >
            {{ data.carat }}
          </option>
        </select>
         <div class="text-red-500" v-if="form.errors.gold_carat_category_id">{{ form.errors.gold_carat_category_id }}</div> 
      </div>
      <Button class="mt-8">Ubah</Button>
      <FlashSuccessAndErrorMessage class="mt-8" />
    </div>
  </form>
</template>
