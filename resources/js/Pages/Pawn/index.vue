<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import mapValues from 'lodash/mapValues'
import NavbarLayout from "@/Layouts/Navbar.vue";
import Label from "@/Components/Label.vue";
import InputBox from "@/Components/Input.vue";
import { GetURLS, GetTitle, isGreenOrRedColor, IsAdmin } from '@/Config';
import Button from '@/Components/Button/Link/Button.vue';
import { RupiahFormat } from '@/Components/utils/Number';
import CustomDropdown from '@/Components/Button/CustomDropdown.vue';
import Input from '@/Components/Input.vue';
import { ButtonDanger } from '@/Components/Button/Link';
import { Pagination } from '@/Components/AddOn';
import { TextContainerDanger } from '@/Components/Text';
import { TextSmall } from '@/Components/Text';
import { Check, Edit, MoreDetail, XIcon } from '@/Components/svg/icon';
import FlashSuccessAndErrorMessageVue from '@/Components/FlashSuccessAndErrorMessage.vue';

export default {
  layout: NavbarLayout,

  props: {
    allPawnTransaction: Object,
    allPawnStatus: Object,
  },

  data() {
    return {
      dataFilter: {
        searchPawnKeyword: '',
        pawnStatusId: [],
        fromDate: '',
        toDate: '',
      },
      titlePage: GetTitle('GoldPawn'),
      model: {
        itemPrice: 100000,
        pawnPrice: 60000,
        tempo: 1,
        interest_total: 0.2,
        totalPrice: 0,
      },
      fromDate: null,
      toDate: null,
    };
  },

  components: {
    Head,
    Label,
    InputBox,
    Link,
    Button,
    CustomDropdown,
    Input,
    ButtonDanger,
    Pagination,
    TextContainerDanger,
    TextSmall,
    MoreDetail,
    Edit,
    Check,
    XIcon,
    FlashSuccessAndErrorMessageVue,
  },

  methods: {
    IsAdmin,
    GetURLS,
    RupiahFormat,
    isGreenOrRedColor,
    Reset() {
      this.dataFilter = mapValues(this.dataFilter, () => null);
      this.dataFilter.pawnStatusId = []
    },
  },

  watch: {
    dataFilter: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get(GetURLS('GoldPawn'), pickBy(this.dataFilter), { preserveState: true })
      }, 150),
    }
  },
};
</script>

<template>
  <Head :title="titlePage" />

  <div class="flex gap-2 items-center">
    <div class="text-2xl">{{ titlePage }}</div>
    <flash-success-and-error-message-vue />
  </div>

  <div class="flex justify-between mt-8">
    <div class="flex gap-2">
      <div class="w-96">
        <input-box type="text" class="block w-96" placeholder="Search" @keyup="Submit" v-model="dataFilter.searchPawnKeyword" />
      </div>
      <div class="w-48">
        <custom-dropdown>
          <template #title>Filter</template>
          <template #content>
            <div class="py-2" v-for="data in allPawnStatus" :key="data.id">
              <input type="checkbox" :id="data.id" :value="data.id" v-model="dataFilter.pawnStatusId" @change="Submit"/>
              <label class="ml-2" :for="data.id">{{data.status}}</label>
            </div>
            <div class="mt-2">
              <span class="py-2 font-bold">Tanggal Batas Pembayaran</span>
              <div class="flex gap-2 content-between py-2">
                <Input class="mt-1" type="date" placeholder="Harga Minimum" @keyup="Submit" v-model="dataFilter.fromDate" @change="Submit" />
                <span class="my-auto">-</span>
                <Input class="mt-1" type="date" placeholder="Harga Maksimum" @keyup="Submit" v-model="dataFilter.toDate" @change="Submit" />
              </div>
            </div>
          </template>
        </custom-dropdown>
      </div>
      <div class="flex">
        <text-small color="text-red-700" @click="Reset">Reset</text-small>
      </div>
    </div>
    <div class="w-48">
      <Link :href="GetURLS('GoldPawn', null, 'add')" preserve-state><Button>Tambah</Button></Link>
    </div>
  </div>

  <div class="mt-8">
    <span class="text-xl block">Transaksi Gadai</span>
    <div class="mt-2">
      <text-container-danger text="Tidak ada Transaksi Gadai" v-if="!allPawnTransaction.data.length" />
      <table v-else>
        <tr>
          <th class="min-w-32">Nama Penjaga</th>
          <th class="min-w-32">Nama Pelanggan</th>
          <th class="min-w-32">Nomor Telpon</th>
          <th class="min-w-32">Tanggal Gadai</th>
          <th class="min-w-32">Batas pembayaran</th>
          <th class="min-w-32">Dana Pinjaman</th>
          <th class="min-w-32">Dana Tebusan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
        <tr :class="isGreenOrRedColor(data.pawn_transaction_status.status === 'done' ? 1 : 0)" v-for="data in allPawnTransaction.data" :key="data.id">
          <td>{{ data.user.name }}</td>
          <td>{{ data.customer.name }}</td>
          <td>{{ data.customer.phone_number }}</td>
          <td>{{ data.created_at }}</td>
          <td>{{ data.deadline_date }}</td>
          <td>{{ RupiahFormat(data.loan_price) }}</td>
          <td>{{ RupiahFormat(data.return_price) }}</td>
          <td>{{ data.pawn_transaction_status.status }}</td>
          <td class="flex gap-2">
            <Link class="cursor-pointer" :href="GetURLS('GoldPawn', data.id)">
              <more-detail />
            </Link>
            <Link class="cursor-pointer" :href="GetURLS('GoldPawn', data.id, 'edit')" v-if="IsAdmin($page.props.auth.user.role_id)">
              <edit />
            </Link>
            <div v-if="IsAdmin($page.props.auth.user.role_id)">
              <Link class="cursor-pointer" :href="`/pawn/${data.id}/showPawnTransactionHeaderAsDonePage`" v-if="data.pawn_transaction_status_id == 2">
                <check />
              </Link>
              <Link class="cursor-pointer" :href="`/pawn/${data.id}/showPawnTransactionHeaderAsUnDonePage`" v-else>
                <x-icon />
              </Link>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div class="mt-2">
    <pagination :links="allPawnTransaction.links"/>
  </div>

</template>
