<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import mapValues from 'lodash/mapValues'
import NavbarLayout from '@/Layouts/Navbar.vue'
import InputBox from '@/Components/Input.vue';
import { URLS, GetURLS, IsAdmin } from '@/Config';
import { Edit, Delete } from '@/Components/svg/icon';
import FlashSuccessAndErrorMessageVue from '@/Components/FlashSuccessAndErrorMessage.vue';
import Button from '@/Components/Button/Link/Button.vue';
import TextContainerDanger from '@/Components/Text/Content/TextContainerDanger.vue';
import { TextSmall } from '@/Components/Text';
import { Pagination } from '@/Components/AddOn';

export default {
  layout: NavbarLayout,

  props: {
    allCustomer: Object,
  },

  data() {
    return {
      URLS,
      TABLE_TITLE: [
        'Nama',
        'Email',
        'Nomor Telepon',
        'Tanggal Lahir',
        'Aksi',
      ],
      dataFilter: {
        name: null,
      }
    }
  },

  components: {
    Head,
    Link,
    InputBox,
    Edit,
    Delete,
    FlashSuccessAndErrorMessageVue,
    Button,
    TextContainerDanger,
    TextSmall,
    Pagination,
  },

  methods: {
    IsAdmin,
    GetURLS,
    Reset() {
      this.dataFilter = mapValues(this.dataFilter, () => null);
      this.dataFilter.pawnStatusId = []
    },
  },

  watch: {
    dataFilter: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get(GetURLS('Customer'), pickBy(this.dataFilter), { preserveState: true })
      }, 150),
    }
  }
}
</script>

<template>
  <Head :title="URLS.Customer.title" />

  <div class="flex gap-2 items-center">
    <div class="text-2xl">{{ URLS.Customer.title }}</div>
    <flash-success-and-error-message-vue />
  </div>

  <div class="flex justify-between mt-8">
    <div class="flex gap-2">
      <div class="w-96">
        <InputBox type="text" class="block flex-grow-1" placeholder="Search" @keyup="SubmitSearch" v-model="dataFilter.name" />
      </div>
      <div class="flex">
        <text-small color="text-red-700" @click="Reset">Reset</text-small>
      </div>
    </div>
    <div class="w-48">
      <Link :href="GetURLS('Customer', null, 'add')">
        <Button>Tambah</Button>
      </Link>
    </div>
  </div>

  <div class="mt-8">
    <text-container-danger text="Tidak ada data Pelanggan" v-if="!allCustomer.data.length"/>
    <table v-else>
      <tr>
        <th :class="index !== TABLE_TITLE.length-1 && 'min-w-32'" v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
      </tr>
      <tr v-for="data in allCustomer.data" :key="data.id">
        <td>{{ data.name }}</td>
        <td>{{ data.email }}</td>
        <td>{{ data.phone_number }}</td>
        <td>{{ data.dob }}</td>
        <td class="flex gap-2">
          <Link :href="GetURLS('Customer', data.id, 'edit')"><Edit /></Link>
          <Link :href="GetURLS('Customer', data.id, 'delete')" method="delete" as="button" @click="SubmitSearch" v-if="IsAdmin($page.props.auth.user.role_id)"><Delete /></Link>
        </td>
      </tr>
    </table>
  </div>

  <div class="mt-2">
    <pagination :links="allCustomer.links"/>
  </div>
</template>
