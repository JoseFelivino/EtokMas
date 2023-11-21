<script>
import { IsAdmin, MENUS } from "@/Config/index"
import { Link } from '@inertiajs/inertia-vue3';
import { URLS } from '@/Config';
import LoadingTemplateSquare from "@/Components/svg/loadingTemplate-one.vue"
import {Bell, BellAlert, DropDown as DropDownIcon, ETokmasLogo} from '@/Components/svg/icon';
import { TextSmall } from '@/Components/Text';
import vClickOutside from 'click-outside-vue3'

export default {
    data() {
        return {
            MENUS,
            URLS,
            isDropDownOpen: false,
            isHasUnreadNotification: false,
            FETCH_UPCOMING_PAWN_DATE: 'FETCH_UPCOMING_PAWN_DATE'
        }
    },

    directives: {
        clickOutside : vClickOutside.directive,
    },

    components: {
        Link,
        LoadingTemplateSquare,
        Bell,
        BellAlert,
        TextSmall,
        DropDownIcon,
        ETokmasLogo,
    },
    methods: {
        IsAdmin,
        getDifferenceBetweenDateString(dateOne, dateTwo) {
            var date1 = new Date(dateOne)
            var date2 = new Date(dateTwo)
            var Difference_In_Time = date2.getTime() - date1.getTime()
            return Math.abs(Difference_In_Time / (1000 * 3600 * 24))
        },
        onClickDropDown() {
            this.isDropDownOpen = !this.isDropDownOpen
        },
        onClickOutsideDropDown() {
            this.isDropDownOpen = false;
        },
        getUnreadNotification() {
            axios.get(`/isHasUnreadNotification`)
                .then((response) => {
                    this.isHasUnreadNotification = response.data.isHasUnreadNotification
                })
        },

        checkForUpcomingPawnAndPushNotif() {
            const fetchUpcomingPawnDate = localStorage.getItem(this.FETCH_UPCOMING_PAWN_DATE)
            if(fetchUpcomingPawnDate) {
                if(this.getDifferenceBetweenDateString(fetchUpcomingPawnDate, new Date().toLocaleString()) >=  1) {
                    axios.get(`/checkForUpcomingPawnAndPushNotif`)
                    localStorage.setItem(this.FETCH_UPCOMING_PAWN_DATE, new Date().toLocaleString())
                }
            } else {
                localStorage.setItem(this.FETCH_UPCOMING_PAWN_DATE, new Date().toLocaleString())
                axios.get(`/checkForUpcomingPawnAndPushNotif`)

            }
        },
        onClickNavbarItem() {
            this.checkForUpcomingPawnAndPushNotif()
            this.getUnreadNotification()
        }
    },
    
    created() {
        this.checkForUpcomingPawnAndPushNotif() 
        setInterval(() => {

            this.checkForUpcomingPawnAndPushNotif()

        }, 7200000);

        this.getUnreadNotification()
        setInterval(() => {

            this.getUnreadNotification()

        }, 3600000);  
    }
}
</script>


<style scoped>
    .navbarScreen {
        min-width: 400px;
    }
</style>


<template>
    <div class="screen flex">
        <div class="navbarSection w-1/4 max-w-xs h-screen p-6 flex flex-col gap-8 bg-blue-300
            shadow-lg rounded-r-lg"
        >
            <div class="flex justify-between items-center">
                <ETokmasLogo class="w-20 max-h-20" />
                <div class="flex flex-col justify-center">
                    <Link :href="URLS.Notification.href" >
                        <BellAlert class="mx-auto" v-if="isHasUnreadNotification"/>
                        <Bell class="mx-auto" v-else/>
                    </Link>
                </div>
            </div>
            <div class="flex gap-2 bg-blue-700 rounded-full p-2 justify-center items-center">
                <text-small class="uppercase text-center" :pointer="false" color="text-white">Selamat Datang {{ $page.props.auth.user.name || 'Silahkan Login' }}</text-small>
                <div class="relative cursor-pointer" @click="isDropDownOpen = !isDropDownOpen">
                    <drop-down-icon class="text-blue-300" />
                    <div class="absolute flex flex-col bg-white rounded-md shadow-lg p-2 w-max z-5" v-if="isDropDownOpen" v-click-outside="onClickOutsideDropDown">
                        <Link v-if="IsAdmin($page.props.auth.user.role_id)" :href="route('employee.edit', $page.props.auth.user.id)">
                            <text-small color="text-blue-700">Ubah Data Diri</text-small>
                        </Link>
                        <Link :href="route('changePassword.index')">
                            <text-small color="text-blue-700">Ganti Password</text-small>
                        </Link>
                        <Link :href="route('logout')" method="post" as="button">
                            <text-small color="text-blue-700">Keluar</text-small>
                        </Link>
                    </div>
                </div>
            </div>
            <div class="flex-grow overflow-y-auto">
                <div
                    v-for="(MENU, index) in MENUS"
                    :key="index"
                >
                    <Link
                        :href="MENU.href"
                        :class="[
                            'flex flex-col w-full p-4',
                            'rounded-md transition-colors hover:bg-blue-700 hover:text-white',
                            ($page.url.startsWith(MENU.href)) && 'bg-blue-700 text-blue-300',
                            (!$page.props.auth.user) && 'pointer-events-none',
                        ]"
                        v-if="IsAdmin($page.props.auth.user.role_id) || !MENU.isAdmin"
                        @click="onClickNavbarItem"
                    >
                        {{MENU.title}}
                    </Link>
                </div>
            </div>
        </div>
        <main class="w-full h-screen overflow-auto">
            <div class="mt-8 p-4">
                <slot />
            </div>
        </main>
    </div>
</template>
