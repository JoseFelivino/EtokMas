<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { GetTitle, GetURLS } from '@/Config';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage.vue';
import TextContainerDanger from '@/Components/Text/Content/TextContainerDanger.vue';
import { Delete, Edit } from '@/Components/svg/icon';
import Pagination from '@/Components/AddOn/Pagination.vue';
import Button from '@/Components/Button/Link/Button.vue';
import { DateForPage } from '@/Components/utils/Date';

export default {
  layout: NavbarLayout,

  props: {
    allEmployee: Object,
  },

  data() {
    return {
      TABLE_TITLE: [
        'Nama',
        'Email',
        'Tanggal Lahir',
        'Role',
        'Alamat',
        'Aksi',
      ],
      titlePage: GetTitle('Employee'),
    }
  },

  components: {
    Head,
    Link,
    FlashSuccessAndErrorMessage,
    TextContainerDanger,
    Edit,
    Delete,
    Pagination,
    Button,
  },

  methods: {
    GetURLS,
    DateForPage,
  }
}
</script>

<template>
  <Head :title="titlePage" />

  <div class="flex items-center gap-2">
    <div class="text-2xl">{{ titlePage }}</div>
    <flash-success-and-error-message />
  </div>

  <div class="mt-8 w-48">
    <Link :href="GetURLS('Register')">
      <Button>Tambah</Button>
    </Link>
  </div>

  <div class="mt-8">
    <text-container-danger text="Tidak ada data Rak" v-if="!allEmployee.data.length" />
    <table v-else>
      <tr>
        <th :class="index !== TABLE_TITLE.length-1 && 'min-w-48'" v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
      </tr>
      <tr v-for="data in allEmployee.data" :key="data.id">
        <td>{{ data.name }}</td>
        <td>{{ data.email }}</td>
        <td>{{ DateForPage(data.dob) }}</td>
        <td>{{ data.role.name }}</td>
        <td>{{ data.address }}</td>
        <td>
          <Link v-if="data.isEmployee" :href="GetURLS('Employee', data.id, 'edit')" as="button"><Edit /></Link>
          <Link v-if="data.isEmployee" :href="GetURLS('Employee', data.id, 'delete')" method="delete" as="button"><Delete /></Link>
        </td>
      </tr>
    </table>
    <pagination class="mt-2" :links="allEmployee.links" />
  </div>
</template>
