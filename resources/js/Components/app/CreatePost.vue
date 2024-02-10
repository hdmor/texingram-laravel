<script setup>
import {ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form_visibility = ref(false);
</script>

<template>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded mb-3">
        <div @click="form_visibility = !form_visibility" class="py-2 px-3 text-gray-400 border border-2 border-gray-200 rounded">
            Click here to create new post
        </div>
        <div v-show="form_visibility" class="flex justify-between gap-2 mt-3">
            <PrimaryButton>Attach Files</PrimaryButton>
            <PrimaryButton>Submit</PrimaryButton>
        </div>
    </div>
</template>

<style scoped>

</style>