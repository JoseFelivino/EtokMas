<script>
import { Link } from '@inertiajs/inertia-vue3';
import throttle from 'lodash/throttle'
import { DateForPage } from '@/Components/utils/Date';
import { Modal } from '../';
import { GetURLS } from '@/Config';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button/Link/Button.vue';
import AxiosValidationErrorsVue from '@/Components/Validation/AxiosValidationErrors.vue';

export default {  
  data() {
    return {
      TABLE_TITLE: [
        'Nama',
        'Email',
        'Nomor Telepon',
        'Tanggal Lahir',
      ],
      customers: '',
      modelCustomer: {
        name: '',
      },
      dataCustomer: {
        email: '',
        name: '',
        phone_number: '',
        dob: '',
      },
      errorAxios: '',
      isModalOpen: false,
      isModalAddCustomerOpen: false,
    }
  },

  components: {
    Link,
    Modal,
    Input,
    Button,
    AxiosValidationErrorsVue,
  },

  methods: {
    GetURLS,
    DateForPage,
    OpenModal() {
      this.isModalOpen = true;
    },
    handleClickCustomer(customer) {
      this.$emit("update:getCustomerId", customer.id);
      this.$emit("update:getCustomerName", customer.name);
      this.isModalOpen = false;
    },
    handleClickAddCustomer() {
      axios.post('/customer/storeUsingAPIBasedRequest', this.dataCustomer)
      .then((response) => {
        this.$emit("update:getCustomerId", response.data.customerId);
        this.$emit("update:getCustomerName", response.data.customerName);
        this.isModalOpen = false;
        this.isModalAddCustomerOpen = false;
        this.fetchCustomer();
      })
      .catch((err) => {
        if (err.response) {
          this.errorAxios = err.response.data.errors;
        }
      })
    },
    fetchCustomer() {
      axios.post(GetURLS('GetCustomerByName'), this.modelCustomer)
      .then((response) => {
        this.customers = response.data.customerResult;
      })
      .catch((err) => {
        console.log(err);
      })
    }
  },

  emits: ['update:getCustomerId', 'update:getCustomerName'],

  watch: {
    modelCustomer: {
      deep: true,
      handler: throttle(function() {
        this.fetchCustomer()
      }, 150)
    }
  },

  mounted() {
    this.fetchCustomer()
  },
}
</script>

<template>
  <modal className="min-h-96" v-if="isModalOpen" @close="isModalOpen = false">
    <div class="text-2xl">Customer</div>
    <div class="mt-4 flex justify-between">
      <div class="w-96">
        <Input type="text" class="block w-96" placeholder="Search" v-model="modelCustomer.name" />
      </div>
      <div class="w-48">
        <Button @click.prevent="isModalAddCustomerOpen = true">Tambah</Button>
      </div>
    </div>
    <table class="mt-4">
      <tr>
        <th class="min-w-48" v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
      </tr>
      <tr class="cursor-pointer" v-for="data in customers" :key="data.id" @click="handleClickCustomer(data)">
        <td>{{ data.name }}</td>
        <td>{{ data.email }}</td>
        <td>{{ data.phone_number }}</td>
        <td>{{ data.dob }}</td>
      </tr>
    </table>
  </modal>

  <modal className="min-h-96" minWidth="min-w-4xl" zIndex="2" v-if="isModalAddCustomerOpen" @close="isModalAddCustomerOpen = false">
    <div class="text-2xl">Tambah Customer</div>
    <axios-validation-errors-vue class="mt-4" :errors="errorAxios" />
    <div class="mt-4 grid grid-cols-2">
      <label class="w-72 font-bold my-auto" for="name">Nama</label>
      <Input
        type="text"
        id="name"
        placeholder="Nama"
        v-model="dataCustomer.name"
        autofocus
      />
    </div>
    <div class="grid grid-cols-2 mt-2">
      <label class="w-72 font-bold my-auto" for="email">Email</label>
      <Input
        type="text"
        id="email"
        placeholder="Email"
        v-model="dataCustomer.email"
      />
    </div>
    <div class="grid grid-cols-2 mt-2">
      <label class="w-72 font-bold my-auto" for="phoneNumber">Nomor Telepon</label>
      <Input
        type="text"
        id="phoneNumber"
        placeholder="Nomor Telepon"
        v-model="dataCustomer.phone_number"
      />
    </div>
    <div class="grid grid-cols-2 mt-2">
      <label class="w-72 font-bold my-auto" for="dob">Tanggal Lahir</label>
      <Input
        type="date"
        id="dob"
        placeholder="Tanggal Lahir"
        v-model="dataCustomer.dob"
      />
    </div>
    <Button class="mt-8" @click.prevent="handleClickAddCustomer">Simpan</Button>
    <flash-success-and-error-message class="mt-8" />
  </modal>
</template>