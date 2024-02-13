<script setup>
import {Head, useForm, usePage} from "@inertiajs/vue3";
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from '@headlessui/vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import Edit from "@/Pages/Profile/Edit.vue";
import {computed, ref, watch} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const user = usePage().props.auth.user;

const props = defineProps({
    errors: Object,
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

const isMyProfile = computed(_ => user && user.id === props.profile.id);
const form = useForm({
    avatar: null,
    cover: null
});
const coverImageSource = ref('');
const onCoverChange = (event) => {
    form.cover = event.target.files[0];
    if (form.cover) {
        const fileReader = new FileReader();
        fileReader.onload = () => {
            coverImageSource.value = fileReader.result
        }
        fileReader.readAsDataURL(form.cover);
    }
}
const cancelCoverImage = _ => {
    form.cover = null;
    coverImageSource.value = null;
}
const submitCoverImage = _ => {
    form.post(route('profile.image'), {
        onSuccess: _ => {
            cancelCoverImage();
        }
    })
}
const statusVisibility = ref(true);
watch(() => props.status, (first, second) => {
    if (first && !second)
        setTimeout(() => {
            statusVisibility.value = false
        }, 3000);
});
</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>
        <div class="w-full px-4 mx-auto h-full overflow-y-auto">
            <div
                v-show="statusVisibility && status === 'update-image'"
                class="my-3 p-3 text-black font-medium text-sm bg-emerald-500 rounded">
                Your profile image has been updated successfully.
            </div>
            <template v-for="error in errors" :key="error">
                <div class="my-3 p-3 text-black font-medium text-sm bg-red-500 rounded">{{ error }}</div>
            </template>
            <div class="relative bg-white dark:bg-gray-800 shadow rounded group">
                <img :src="coverImageSource || profile.cover_url || '/images/cover.jpg'" alt="cover"
                     class="w-full h-[350px] object-cover object-center hover:object-top transition-all">
                <div class="absolute top-2 right-2">
                    <PrimaryButton v-if="!coverImageSource"
                                   class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-80 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <g transform="translate(2 3)">
                                <path d="M20 16a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h3l2-3h6l2 3h3a2 2 0 0 1 2 2v11z"/>
                                <circle cx="10" cy="10" r="4"/>
                            </g>
                        </svg>
                        Update Cover Image
                        <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0" @change="onCoverChange">
                    </PrimaryButton>
                    <template v-else>
                        <SecondaryButton @click="cancelCoverImage"
                                         class="flex me-2 items-center justify-center gap-2 opacity-0 group-hover:opacity-80 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            Cancel
                        </SecondaryButton>
                        <PrimaryButton @click="submitCoverImage"
                                       class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-80 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Submit
                        </PrimaryButton>
                    </template>
                </div>
                <div class="flex">
                    <img src="/images/profile.png" alt="profile" class="ml-[48px] -mt-[96px] w-[128px] h-[128px] rounded-full">
                    <div class="flex justify-between items-center flex-1 p-4">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ profile.name }}</h2>
                        <PrimaryButton v-if="isMyProfile" class="flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon>
                            </svg>
                            Edit Profile
                        </PrimaryButton>
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