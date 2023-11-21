<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavbarLayout from '@/Layouts/Navbar.vue'
import { 
    URLS, 
    GetURLSMarkAsReadNotification, 
    GetURLSMarkAllUnreadNotificationsAsReadNotification, 
    GetURLSDeleteNotification,
    GetURLSDestroyAllUnreadNotifications,
    GetURLSDestroyAllReadNotifications 
} from '@/Config';
import { Edit, Delete} from '@/Components/svg/icon';
import FlashSuccessAndErrorMessage from '@/Components/FlashSuccessAndErrorMessage'
import { TextContainerDanger } from '@/Components/Text';

export default {
    layout: NavbarLayout,

    props: {
        allUnreadNotifications: Object,
        allReadNotifications: Object
    },

    data() {
      return {
        URLS,
        TABLE_TITLE: [
          'Pesan',
          'Aksi',
        ]
      }
    },

    components: {
        Head,
        Link,
        Edit,
        Delete,
        FlashSuccessAndErrorMessage,
        TextContainerDanger,
    },

    methods: {
        GetURLSMarkAsReadNotification, 
        GetURLSMarkAllUnreadNotificationsAsReadNotification, 
        GetURLSDeleteNotification,
        GetURLSDestroyAllUnreadNotifications,
        GetURLSDestroyAllReadNotifications 
    }
}
</script>

<template>
    <Head :title="URLS.Notification.title" />

    <div class="flex gap-2">
        <div class="text-2xl">{{ URLS.Notification.title }}</div>
        <flash-success-and-error-message />
    </div>

    <div class="text-xl mt-8">Notifikasi yang belum di baca :</div>
    
    <div class="mt-2">
        <text-container-danger text="Tidak ada Notifikasi yang belum di baca" v-if="!allUnreadNotifications.data.length" />
        <div class="inline-block" v-else>
            <table>
                <tr>
                    <th :class="index !== TABLE_TITLE.length-1 && 'min-w-96'" v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
                </tr>
                <tr v-for="data in allUnreadNotifications.data" :key="data.id">
                    <td>{{ data.message }}</td>
                    <td class="flex gap-2">
                        <Link :href="GetURLSMarkAsReadNotification(data.id)" method="put"> Tandai Sudah Di Baca</Link>
                        <Link :href="GetURLSDeleteNotification(data.id)" method="delete"><Delete /></Link>
                    </td>
                </tr>
            </table>
            <div class="flex justify-between">
                <Link class="text-blue-700" :href="GetURLSMarkAllUnreadNotificationsAsReadNotification()" method="put" as="button">Tandai Semua Sudah Dibaca</Link>
                <Link class="text-red-700" :href="GetURLSDestroyAllUnreadNotifications()" method="delete" as="button">Hapus Semua</Link>
            </div>
        </div>
    </div>

    <div class="text-xl mt-8">Notifikasi yang sudah di baca :</div>
    
    <div class="mt-2">
        <text-container-danger text="Tidak ada Notifikasi yang sudah di baca" v-if="!allReadNotifications.data.length" />
        <div class="inline-block" v-else>
            <table>
                <tr>
                    <th :class="index !== TABLE_TITLE.length-1 && 'min-w-96'" v-for="(data, index) in TABLE_TITLE" :key="index">{{ data }}</th>
                </tr>
                <tr v-for="data in allReadNotifications.data" :key="data.id">
                    <td>{{ data.message }}</td>
                    <td class="flex">
                        <Link :href="GetURLSDeleteNotification(data.id)" method="delete"><Delete /></Link>
                    </td>
                </tr>
            </table>
            <div class="flex justify-between">
                <div />
                <Link class="text-red-700" :href="GetURLSDestroyAllReadNotifications()" method="delete" as="button">Hapus Semua</Link>
            </div>
        </div>
    </div>

</template>
