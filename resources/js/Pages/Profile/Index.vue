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
    success_message: {
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
const avatarImageSource = ref('');
const coverImageSource = ref('');
const onAvatarChange = (event) => {
    form.avatar = event.target.files[0];
    if (form.avatar) {
        const fileReader = new FileReader();
        fileReader.onload = () => {
            avatarImageSource.value = fileReader.result
        }
        fileReader.readAsDataURL(form.avatar);
    }
}
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
const resetAvatarImage = _ => {
    form.avatar = null;
    avatarImageSource.value = null;
}
const resetCoverImage = _ => {
    form.cover = null;
    coverImageSource.value = null;
}
const submitAvatarImage = _ => {
    form.post(route('profile.image'), {
        onSuccess: _ => {
            resetAvatarImage();
        }
    })
}
const submitCoverImage = _ => {
    form.post(route('profile.image'), {
        onSuccess: _ => {
            resetCoverImage();
        }
    })
}
const successMessageVisibility = ref(true);
watch(() => props.success_message, _ => {
    successMessageVisibility.value = true;
    setTimeout(() => {
        successMessageVisibility.value = false;
    }, 3000);
})
</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>
        <div class="w-full px-4 mx-auto h-full overflow-y-auto">
            <div v-show="successMessageVisibility && success_message" class="my-3 p-3 text-black font-medium text-sm bg-emerald-500 rounded">
                {{ success_message }}
            </div>
            <template v-for="error in errors" :key="error">
                <div class="my-3 p-3 text-black font-medium text-sm bg-red-500 rounded">{{ error }}</div>
            </template>
            <div class="relative bg-white dark:bg-gray-800 shadow rounded group">
                <img :src="coverImageSource || profile.cover_url || '/images/cover.jpg'" alt="cover"
                     class="w-full h-[350px] object-cover object-center hover:object-top transition-all">
                <div class="absolute top-2 right-2 inline-block">
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
                        <input type="file" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" @change="onCoverChange">
                    </PrimaryButton>
                    <template v-else>
                        <SecondaryButton @click="resetCoverImage"
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
                    <div class="relative group/avatar flex items-center justify-center ml-[48px] -mt-[96px] w-[128px] h-[128px]">
                        <img :src="avatarImageSource || profile.avatar_url || '/images/profile.png'" alt="profile"
                             class="border w-full h-full rounded-full object-cover">
                        <button v-if="!avatarImageSource"
                                class="absolute w-full h-full flex items-center justify-center bg-black/50 opacity-0 group-hover/avatar:opacity-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <g transform="translate(2 3)">
                                    <path d="M20 16a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h3l2-3h6l2 3h3a2 2 0 0 1 2 2v11z"/>
                                    <circle cx="10" cy="10" r="4"/>
                                </g>
                            </svg>
                            <input type="file" class="absolute w-full h-full opacity-0 cursor-pointer" @change="onAvatarChange">
                        </button>
                        <div v-else class="absolute top-0 right-0 flex flex-col gap-1">
                            <button @click="resetAvatarImage" class="p-2 rounded-full bg-red-500/50 hover:bg-red-500/75">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                            <button @click="submitAvatarImage" class="p-2 rounded-full bg-emerald-500/50 hover:bg-emerald-500/75">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <h2 class="py-3 text-xl font-semibold text-gray-900 dark:text-gray-100">{{ profile.name }}</h2>
                </div>
            </div>
            <div class="border-t">
                <TabGroup>
                    <TabList class="flex bg-white rounded-b">
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
                        <Tab v-if="isMyProfile" as="template" v-slot="{ selected }">
                            <TabItem :selected="selected" title="My Profile"/>
                        </Tab>
                    </TabList>

                    <TabPanels class="my-4">
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
                        <TabPanel key="about" v-if="isMyProfile">
                            <Edit :must-verify-email="mustVerifyEmail" :status="status"/>
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>