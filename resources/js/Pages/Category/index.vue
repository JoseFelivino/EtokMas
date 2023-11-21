<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLS, GetURLSAddCategory, GetURLSEditCategory, GetURLSDeleteCategory } from '@/Config';
import { Edit, Delete } from '@/Components/svg/icon';
import { Button } from '@/Components/Button/Link';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import { TextContainerDanger } from '@/Components/Text';

export default {
    layout: NavbarLayout,

    props: {
      allCategory: Object,
    },

    data() {
      return {
        URLS,
        TABLE_TITLE: [
          'Nama Category',
          'Aksi',
        ]
      }
    },

    components: {
        Head,
        Link,
        Button,
        Edit,
        Delete,
        TextContainerDanger,
        FlashSuccessAndErrorMessage,
    },

    methods: {
      GetURLSAddCategory,
      GetURLSEditCategory,
      GetURLSDeleteCategory,
    }
}
</script>

<template>
  <Head :title="URLS.Category.title" />

  <div class="flex items-center gap-2">
    <div class="text-2xl">{{ URLS.Category.title }}</div>
    <flash-success-and-error-message />
  </div>

  <div class="mt-8 w-36">
    <Link :href="GetURLSAddCategory()"><Button>Tambah</Button></Link>
  </div>

  <div class="mt-8">
    <text-container-danger text="Tidak ada Kategori" v-if="!allCategory.length"/>
    <table v-else>
      <tr>
        <th :class="index !== TABLE_TITLE.length-1 && 'min-w-48'" v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
      </tr>
      <tr v-for="data in allCategory" :key="data.id">
        <td>{{ data.name }}</td>
        <td class="grid grid-cols-2 gap-2">
          <Link :href="GetURLSEditCategory(data.id)" as="button"><Edit /></Link>
          <Link :href="GetURLSDeleteCategory(data.id)" method="delete" as="button"><Delete /></Link>
        </td>
      </tr>
    </table>
  </div>
</template>
