<script setup>
import {ref} from "vue";
import PostEditModal from "@/Components/app/PostCreateOrEditFormModal.vue";
import {usePage} from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const createPostModalVisibility = ref(false);
const newPost = ref({
    id: null,
    body: '',
    user: usePage().props.auth.user
});
</script>

<template>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded mb-3">
        <SecondaryButton @click="createPostModalVisibility = !createPostModalVisibility"
                         class="py-3 w-full flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Click here to create new post
        </SecondaryButton>
        <!--        <div class="flex justify-between gap-2 mt-3">
                    <SecondaryButton>Attach Files</SecondaryButton>
                    <PrimaryButton @click="submit">Submit</PrimaryButton>
                </div>-->
        <PostEditModal :post="newPost" v-model="createPostModalVisibility"/>
    </div>
</template>

<style scoped>

</style>