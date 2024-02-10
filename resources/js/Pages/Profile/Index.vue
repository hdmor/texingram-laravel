<script setup>
import {Head, usePage} from "@inertiajs/vue3";
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from '@headlessui/vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import Edit from "@/Pages/Profile/Edit.vue";
import {computed} from "vue";

const user = usePage().props.auth.user;

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    profile: {
        type: Object,
    }
});

const isMyProfile = computed(_ => user && user.id === props.profile.id)

</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>
        <div class="w-full px-4 mx-auto h-full overflow-y-auto">
            <div class="relative bg-white dark:bg-gray-800 shadow rounded">
                <img src="/images/cover.png" alt="cover" class="w-full h-[200px] object-cover">
                <div class="flex">
                    <img src="/images/profile.png" alt="profile" class="ml-[48px] -mt-[96px] w-[128px] h-[128px] rounded-full">
                    <div class="flex justify-between items-center flex-1 p-4">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ profile.name }}</h2>
                        <button v-if="isMyProfile" type="button" class="inline-flex items-center px-4 py-2 bg-indigo-400 hover:bg-indigo-300 rounded-md font-semibold text-xs">
                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon>
                            </svg>
                            Edit Profile
                        </button>
                    </div>
                </div>
            </div>
            <div class="border-t">
                <TabGroup>
                    <TabList class="flex bg-white rounded-b">
                        <Tab v-if="isMyProfile" as="template" v-slot="{ selected }">
                            <TabItem :selected="selected" title="About"/>
                        </Tab>
                        <Tab as="template" v-slot="{ selected }">
                            <TabItem :selected="selected" title="Posts"/>
                        </Tab>
                        <Tab as="template" v-slot="{ selected }">
                            <TabItem :selected="selected" title="Followers"/>
                        </Tab>
                        <Tab as="template" v-slot="{ selected }">
                            <TabItem :selected="selected" title="Followings"/>
                        </Tab>
                        <Tab as="template" v-slot="{ selected }">
                            <TabItem :selected="selected" title="Photos"/>
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-6 mb-4">
                        <TabPanel key="about" v-if="isMyProfile">
                            <Edit :must-verify-email="mustVerifyEmail" :status="status"/>
                        </TabPanel>
                        <TabPanel key="posts" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Posts</h2>
                        </TabPanel>
                        <TabPanel key="followers" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Followers</h2>
                        </TabPanel>
                        <TabPanel key="followings" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Followings</h2>
                        </TabPanel>
                        <TabPanel key="photos" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Photos</h2>
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>