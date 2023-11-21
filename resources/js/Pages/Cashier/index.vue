<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import mapValues from 'lodash/mapValues'
import LoadingTemplateSquare from '@/Components/svg/loadingTemplate-one.vue';
import InputBox from '@/Components/Input.vue';
import CustomDropdown from '@/Components/Button/CustomDropdown.vue';
import { RupiahFormat, WeightFormat } from '@/Components/utils/Number';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { Button } from '@/Components/Button/Link';
import { GetTitle, GetURLS } from '@/Config';
import Pagination from '@/Components/AddOn/Pagination.vue';
import axios from 'axios';
import { Trash, Minus, Plus } from '@/Components/svg/icon';
import { Inertia } from '@inertiajs/inertia';
import { TextContainerPrimary, TextSmall } from '@/Components/Text';
import TextContainerDanger from '@/Components/Text/Content/TextContainerDanger.vue';
import GetCustomerModal from '@/Components/Modal/Content/GetCustomerModal.vue';
import FlashSuccessAndErrorMessageVue from '@/Components/FlashSuccessAndErrorMessage.vue';

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
      titlePage: GetTitle('Cashier'),
      dataCart: {
        carts: [],
        quantities: Object,
        totalPrice: 0,
      },
      CartLocalData: [],
      customer: {
        id: '',
        name: '',
      },
      dataFilter: {
        stockCategories: [],
        searchStockKeyword: '',
        caratId: '',
        shelfId: '',
        minPrice: '',
        maxPrice: '',
        minWeight: '',
        maxWeight: '',
      },
    }
  },

  mounted() {
    const CartLocalData = JSON.parse(localStorage.getItem("carts"));

    if (CartLocalData) {
      this.CartLocalData = CartLocalData;
    }
  },

  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    LoadingTemplateSquare,
    InputBox,
    Button,
    CustomDropdown,
    Pagination,
    TextSmall,
    Trash,
    Minus,
    Plus,
    TextContainerDanger,
    TextContainerPrimary,
    GetCustomerModal,
    FlashSuccessAndErrorMessageVue
  },

  methods: {
    WeightFormat,
    RupiahFormat,
    GetURLS,
    DataReset() {
      this.dataFilter = mapValues(this.dataFilter, () => '');
      this.dataFilter.stockCategories = [];
    },
    plusCart(value) {
      let isOnCart = null;
      this.dataCart.carts.map((item) => {
        if(item.id === value && item.quantity > this.dataCart.quantities[value]) {
          this.CartLocalData.push(value);
          isOnCart = 1;
        } else if (item.id === value && item.quantity <= this.dataCart.quantities[value]) {
          isOnCart = 1;
          alert("Item melebihi Stock!!!")
        }
      })
      if(!isOnCart) {
          this.CartLocalData.push(value);
      }
    },
    minusCart(value) {
      var index = this.CartLocalData.indexOf(value);
      if (index !== -1) {
        this.CartLocalData.splice(index, 1);
      }
    },
    removeCart(value) {
      let index = this.CartLocalData.indexOf(value);

      while (index !== -1) {
        this.CartLocalData.splice(index, 1);
        index = this.CartLocalData.indexOf(value);
      }
    },
    checkout() {
      const checkoutData = this.dataCart.carts.map((item) => {
        return {
          'stockId': item.id,
          'quantity': this.dataCart.quantities[item.id],
          'price': item.price,
        }
      })

      if(checkoutData.length && this.customer.id !== ''){
        if (confirm("Apakah anda yakin?") == true) {
          Inertia.post(GetURLS('Cashier', 'checkout'), {
            'cartItems': checkoutData,
            'customerId': this.customer.id,
          })
          this.CartLocalData = [];
        }
      }
    },

    fetchGetStockById() {
       axios.post(GetURLS('GetStockById'), {
            id: this.CartLocalData,
            })
            .then((response) => {
              this.dataCart.carts = response.data.stockResult;
              this.dataCart.quantities = response.data.quantity;
              this.dataCart.totalPrice = response.data.totalPrice;
            })
            .catch((err) => {
              console.log(err);
            })
            if (this.CartLocalData.length !== 0) {
              localStorage.setItem("carts", JSON.stringify(this.CartLocalData))
            } else {
              localStorage.removeItem("carts")
            }
      }
  },

  watch: {
    dataFilter: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get(GetURLS('Cashier'), pickBy(this.dataFilter), { preserveState: true })
      }, 150),
    },
    CartLocalData: {
      deep: true,
      handler: throttle(function () {
        if(this.CartLocalData.length == 0){
          setTimeout(() => {
            this.fetchGetStockById()
          }, 800);

          return
        }
        this.fetchGetStockById()
      }, 150),
    },
  }
}
</script>
<template>
  <Head :title="titlePage" />

  <div class="flex gap-8">
    <div class="min-w-4xl">
      <div class="flex gap-2 items-center">
        <div class="text-2xl">{{ titlePage }}</div>
        <flash-success-and-error-message-vue />
      </div>

      <div class="flex gap-2 mt-8">
        <div class="w-96">
          <InputBox type="text" class="block w-96" placeholder="Search" v-model="dataFilter.searchStockKeyword" />
        </div>
        <div class="w-48">
          <CustomDropdown>
            <template #title>Filter</template>
            <template #content>
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
                  <span>Berat Terendah: {{ WeightFormat(lightestGoldValueInStock) }}</span>
                  <InputBox class="mt-1" type="text" placeholder="Berat Minimum" v-model="dataFilter.minWeight" />
                </div>
                <div class="flex flex-col text-xs ml-2">
                  <span>Berat Tertinggi: {{ WeightFormat(heaviestGoldValueInStock) }}</span>
                  <InputBox class="mt-1" type="text" placeholder="Berat Maksimum" v-model="dataFilter.maxWeight" />
                </div>
              </div>
            </template>
          </CustomDropdown>
        </div>
        <text-small color="text-red-700" @click="DataReset">Reset</text-small>
      </div>

      <div class="cardContainer mt-8">
        <div class="card flex flex-col justify-between max-w-52" v-for="data in allItemsInStock.data" :key="data.id">
          <Link :href="GetURLS('Stock', data.id)">
            <div class="imgContainer">
              <img :src="data.gold.img_path">
            </div>
            <div class="p-2">
              <div><span class="title">{{data.gold.name}}</span></div>
              <div class="description"><span>Berat : </span><span>{{data.gold.weight}}</span></div>
              <div class="description"><span>Jumlah : </span><span>{{data.quantity}}</span></div>
              <div class="description"><span>Karat : </span><span>{{data.gold.gold_carat_category.carat}}</span></div>
              <div class="description"><span>Harga : </span><span>{{RupiahFormat(data.price)}}</span></div>
            </div>
          </Link>
          <Link><Button @click.prevent="plusCart(data.id)">Tambah Ke Keranjang</Button></Link>
        </div>
      </div>
      <div class="mt-2">
        <pagination :links="allItemsInStock.links" />
      </div>
    </div>

    <div class="w-full">
      <div class="flex justify-between">
        <div class="flex gap-2">
          <div class="text-2xl">Keranjang</div>
          <Button @click="$refs['getCustomer'].OpenModal()">Cari Pelanggan</Button>
          <get-customer-modal ref="getCustomer" v-model:getCustomerId="customer.id" v-model:getCustomerName="customer.name" />
        </div>
        <div class="w-48">
          <Button @click="checkout">Checkout</Button>
        </div>
      </div>

      <div class="mt-8">
        <text-container-danger text="Tidak ada items pada keranjang" v-if="!dataCart.carts.length" />
        <div class="cardContainer grid-cols-1 mt-8" v-else>
          <text-container-primary>
            <span>Nama Pelanggan : <span class="font-bold">{{ customer.name || 'Belum Memilih Customer' }}</span></span>
            <span>Total Harga : <span class="font-bold">{{ RupiahFormat(dataCart.totalPrice) }}</span></span>
          </text-container-primary>
          <div class="card w-full" v-for="data in dataCart.carts" :key="data.id">
            <div class="flex gap-2">
              <Link :href="GetURLS('Stock', data.id)">
                <div class="max-h-36">
                  <img class="w-48 max-h-48" :src="data.gold.img_path">
                </div>
              </Link>
                <div class="flex-grow-2">
                  <div class="p-2">
                  <div class="description"><span>Name : </span><span>{{ data.gold.name }}</span></div>
                  <div class="description"><span>Harga : </span><span>{{ RupiahFormat(data.price) }}</span></div>
                  <div class="description"><span>Jumlah : </span><span>{{ dataCart.quantities[data.id] }}</span></div>
                  <div class="flex gap-2">
                    <div class="cursor-pointer" @click="minusCart(data.id)">
                      <button><minus /></button>
                    </div>
                    <div class="cursor-pointer" @click="plusCart(data.id)">
                      <button><plus /></button>
                    </div>
                    <div class="cursor-pointer" @click="removeCart(data.id)">
                      <button><trash /></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
