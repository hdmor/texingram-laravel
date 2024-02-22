<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import GroupListItems from "@/Components/app/GroupListItems.vue";
</script>

<template>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded overflow-hidden h-full">
        <div class="block lg:hidden">
            <Disclosure v-slot="{ open }">
                <DisclosureButton class="flex items-center w-full justify-between">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">My Groups</h2>
                    <svg :class="open ? 'rotate-90 transform' : ''" class="transition-all" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </DisclosureButton>
                <DisclosurePanel>
                    <GroupListItems/>
                </DisclosurePanel>
            </Disclosure>
        </div>
        <div class="h-full lg:flex flex-col overflow-hidden hidden">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">My Groups</h2>
            <GroupListItems/>
        </div>
    </div>
</template>

<style scoped>

</style>