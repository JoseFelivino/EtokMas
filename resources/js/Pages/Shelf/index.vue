<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { URLS, GetURLSEditShelf, GetURLSDeleteShelf, GetURLSAddShelf } from '@/Config';
import { Edit, Delete } from '@/Components/svg/icon';
import { Button } from '@/Components/Button/Link';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import { TextContainerDanger } from '@/Components/Text';

export default {
    layout: NavbarLayout,

    props: {
      allShelf: Object,
    },

    data() {
      return {
        URLS,
        TABLE_TITLE: [
          'Nama Rak',
          'Aksi',
        ],
      }
    },

    components: {
        Head,
        Link,
        Button,
        Edit,
        Delete,
        FlashSuccessAndErrorMessage,
        TextContainerDanger,
    },

    methods: {
      GetURLSAddShelf,
      GetURLSEditShelf,
      GetURLSDeleteShelf,
    }
}
</script>

<template>
  <Head :title="URLS.Shelf.title" />

  <div class="flex items-center gap-2">
    <div class="text-2xl">{{ URLS.Shelf.title }}</div>
    <FlashSuccessAndErrorMessage />
  </div>

  <div class="mt-8 w-36">
    <Link :href="GetURLSAddShelf()"><Button>Tambah</Button></Link>
  </div>

  <div class="mt-8">
    <text-container-danger text="Tidak ada data Rak" v-if="!allShelf.length" />
    <table v-else>
      <tr>
        <th :class="index !== TABLE_TITLE.length-1 && 'min-w-48'" v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
      </tr>
      <tr v-for="data in allShelf" :key="data.id">
        <td>{{ data.name }}</td>
        <td class="flex gap-2">
          <Link :href="GetURLSEditShelf(data.id)" as="button"><Edit /></Link>
          <Link :href="GetURLSDeleteShelf(data.id)" method="delete" as="button"><Delete /></Link>
        </td>
      </tr>
    </table>
  </div>
</template>
