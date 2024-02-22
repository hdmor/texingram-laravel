<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PostUserHeader from "@/Components/app/PostUserHeader.vue";

const props = defineProps({
    post: Object
});

const emit = defineEmits(['openEditModal']);

const is_image = (attachment) => {
    return attachment.mime.split('/')[0].toLowerCase() === 'image'
}

const openEditModal = _ => {
    emit('openEditModal', props.post)
};
</script>

<template>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded p-4 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <PostUserHeader :post="post"/>
            <Menu as="div" class="relative inline-block text-left ms-auto">
                <div>
                    <MenuButton class="rounded-full hover:bg-black/25 transition p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="12" cy="5" r="1"></circle>
                            <circle cx="12" cy="19" r="1"></circle>
                        </svg>
                    </MenuButton>
                </div>

                <transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="transform scale-95 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="transform scale-100 opacity-100"
                    leave-to-class="transform scale-95 opacity-0">

                    <MenuItems
                        class="absolute right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                        <div class="px-1 py-1">
                            <MenuItem v-slot="{ active }">
                                <button @click="openEditModal"
                                        class="text-gray-900 group flex gap-2 px-3 w-full items-center rounded-md px-2 py-2 text-sm hover:bg-indigo-500 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon>
                                    </svg>
                                    Edit
                                </button>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <button
                                    class="text-gray-900 group flex gap-2 px-3 w-full items-center rounded-md px-2 py-2 text-sm hover:bg-indigo-500 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                    Delete
                                </button>
                            </MenuItem>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
        <div>
            <Disclosure v-slot="{ open }">
                <div v-show="!open" v-html="post.body.substring(0,200)" class="text-sm text-gray-600 dark:text-gray-400"/>
                <template v-if="post.body.length >= 200">
                    <DisclosurePanel>
                        <div v-html="post.body" class="text-sm text-gray-600 dark:text-gray-400"/>
                    </DisclosurePanel>
                    <div class="flex justify-end my-3">
                        <DisclosureButton class="text-blue-500 hover:underline">Read {{ open ? 'Less' : 'More' }}</DisclosureButton>
                    </div>
                </template>
            </Disclosure>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 mb-3">
            <template v-for="attachment of post.attachments" :key="attachment.id">
                <div class="group bg-blue-100 aspect-square flex flex-col items-center justify-center relative">
                    <button
                        class="opacity-0 group-hover:opacity-100 transition-all w-8 h-8 flex items-center justify-center bg-gray-700 hover:bg-gray-800 rounded absolute right-2 top-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5"/>
                        </svg>
                    </button>
                    <img v-if="is_image(attachment)" :src="attachment.url" :alt="attachment.name" class="aspect-square object-cover">
                    <template v-else>
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V9l-7-7z"/>
                            <path d="M13 3v6h6"/>
                        </svg>
                        <small>{{ attachment.name }}</small>
                    </template>
                </div>
            </template>
        </div>
        <div class="flex gap-2">
            <PrimaryButton class="flex flex-1 items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                </svg>
                Like
            </PrimaryButton>
            <PrimaryButton class="flex flex-1 items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                </svg>
                Comment
            </PrimaryButton>
        </div>
    </div>
</template>

<style scoped>

</style>