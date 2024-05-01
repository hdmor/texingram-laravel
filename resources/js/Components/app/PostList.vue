<script setup>
import PostItem from "@/Components/app/PostItem.vue";
import PostEditModal from "@/Components/app/PostCreateOrEditFormModal.vue";
import {ref} from "vue";

defineProps({
    posts: Array
});

const showEditModal = ref(false);
const editPost = ref({});

const openEditModal = (post) => {
    editPost.value = post;
    showEditModal.value = true;
};
</script>

<template>
    <div class="overflow-y-auto space-y-3">
        <PostItem v-for="post of posts" :key="post.id" :post="post" @openEditModal="openEditModal"/>
        <PostEditModal :post="editPost" v-model="showEditModal"/>
    </div>
</template>

<style scoped>

</style>