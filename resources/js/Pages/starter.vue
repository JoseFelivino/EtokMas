<script>
import { Head } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { GetTitle } from '@/Config';

export default {
  layout: NavbarLayout,

  props: {

  },

  data() {
    return {
      GetTitle,
    }
  },

  components: {
    Head,
  },
}
</script>

<template>
  <!-- <Head :title="" /> -->

  <div class="text-2xl"></div>
</template>
