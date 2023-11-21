<script>
import { Head } from "@inertiajs/inertia-vue3";
import { URLS, URLSub } from "@/Config/index";
import Button from "@/Components/Button/Link/Button.vue";
import Input from "@/Components/Input.vue";
import CustomDropdown from "@/Components/Button/CustomDropdown.vue";
import NavbarLayout from "@/Layouts/Navbar.vue";
import FileInput from '@/Components/FileInput'
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import { Modal } from "@/Components/Modal";
import { TextValidationError } from '@/Components/Text';

export default {
  layout: NavbarLayout,

  props: {
    allGoldCaratCategory: Object,
    allGoldCategory: Object,
    allShelf: Object,
    successMessage: String,
    errors: Object,
  },

  data() {
    return {
      URLS,
      URLSub,
      form: this.$inertia.form({
        name: "",
        weight: "",
        quantity: "",
        image: "",
        category_id: [],
        shelf_id: "",
        gold_carat_category_id: "",
      }),
      isModalOpen: false,
      
    };
  },

  components: {
    Head,
    Button,
    Input,
    CustomDropdown,
    FlashSuccessAndErrorMessage,
    TextValidationError,
    FileInput,
    Modal,
  },

  methods: {
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    },
    SubmitEvent() {
      this.form.post(URLS.Stock.href, {
          onSuccess: () => this.form.reset()
      });
    },
  },
   watch: {
    '$page.props.flash.goldId': {
      handler() {
        this.isModalOpen = true
      },
    },
  },
};
</script>
<template>
  <Head :title="URLSub.addStock.title" />

  <div class="flex gap-2 items-center">
    <h1 class="text-2xl">{{ URLSub.addStock.title }}</h1>
    <flash-success-and-error-message class="mt-8" />
  </div>

  <form class="mt-8 max-w-screen-sm" @submit.prevent="SubmitEvent">
    <div class="grid grid-cols-2">
      <label class="w-72 font-bold my-auto" for="name">Nama</label>
      <div class="flex flex-col">
        <Input
          type="text"
          id="name"
          placeholder="Nama"
          v-model="form.name"
          autocomplete="stock-name"
          autofocus
        />
        <text-validation-error error="name" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-4">
      <label class="w-72 font-bold my-auto" for="weight">Berat</label>
      <div class="flex flex-col">
        <Input
          type="number"
          id="weight"
          placeholder="Berat"
          step="0.01"
          v-model="form.weight"
        />
        <text-validation-error error="weight" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-4">
      <label class="w-72 font-bold my-auto" for="quantity">Jumlah</label>
      <div class="flex flex-col">
        <Input
          type="number"
          id="quantity"
          placeholder="Jumlah"
          v-model="form.quantity"
        />
        <text-validation-error error="quantity" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-4">
      <label class="w-72 font-bold my-auto" for="image">Gambar</label>
      <div class="flex flex-col">
        <FileInput
          type="file"
          accept="image/*"
          id="image"
          v-model="form.image"
        />
        <text-validation-error error="image" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-4">
      <label class="w-72 font-bold my-auto" for="category">Kategori</label>
      <div class="flex flex-col">
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
        <text-validation-error error="category_id" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-4">
      <label class="w-72 font-bold my-auto" for="rack">Rak</label>
      <div class="flex flex-col">
        <select name="shelf_id" id="rack" v-model="form.shelf_id">
          <option selected="selected" value="">Pilih rak</option>
          <option v-for="data in allShelf" :key="data.id" :value="data.id">
            {{ data.name }}
          </option>
        </select>
        <text-validation-error error="shelf_id" />
      </div>
    </div>
    <div class="grid grid-cols-2 mt-4">
      <label class="w-72 font-bold my-auto" for="carat">Karat</label>
      <div class="flex flex-col">
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
        <text-validation-error error="gold_carat_category_id" />
      </div>
    </div>
    <Button class="mt-8"> Tambah </Button>
  </form>

  <modal class="flex-col" @close="toggleModal" v-if="isModalOpen && $page.props.flash.goldId != null">
    <h1 class="mb-5 text-xl"> Id Produk Emas Yang Telah Di Buat: </h1>
    <div class="font-bold">{{$page.props.flash.goldId || 'Error data is NULL'}}</div>
  </modal>
</template>
