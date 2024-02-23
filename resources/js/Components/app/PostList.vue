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

const post1 = {
    user: {
        id: 1,
        avatar: 'images/profile.png',
        name: 'michel antony'
    },
    group: null,
    body: `<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur consequuntur culpa, cumque delectus ea fuga iste, labore molestiae nam nemo numquam porro possimus provident rem similique sunt temporibus velit.</p><br><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus beatae consequuntur, cumque dolores earum eum explicabo facere maiores officiis omnis quae tempora, tenetur voluptates? Adipisci beatae dignissimos dolore excepturi sapiente.</p>`,
    created_at: '2012-01-19 23:59'
}
const post2 = {
    user: {
        id: 1,
        avatar: 'images/profile.png',
        name: 'michel antony'
    },
    group: {
        id: 1,
        name: 'Laravel Developers'
    },
    body: `<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur consequuntur culpa, cumque delectus ea fuga iste, labore molestiae nam nemo numquam porro possimus provident rem similique sunt temporibus velit.</p><br><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus beatae consequuntur, cumque dolores earum eum explicabo facere maiores officiis omnis quae tempora, tenetur voluptates? Adipisci beatae dignissimos dolore excepturi sapiente.</p>`,
    created_at: '2012-01-19 23:59'
}
const post3 = {
    user: {
        id: 1,
        avatar: 'images/profile.png',
        name: 'michel antony'
    },
    group: {
        id: 1,
        name: 'Laravel Developers'
    },
    attachments: [
        {
            id: 1,
            name: 'profile.png',
            mime: 'image/png',
            url: 'images/profile.png'
        },
        {
            id: 2,
            name: 'profile2.png',
            mime: 'image/png',
            url: 'images/profile.png'
        },
        {
            id: 3,
            name: 'myDoc.docx',
            mime: 'application/msword',
            url: 'assets/myDoc.docx'
        }
    ],
    body: `<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur consequuntur culpa, cumque delectus ea fuga iste, labore molestiae nam nemo numquam porro possimus provident rem similique sunt temporibus velit.</p><br><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus beatae consequuntur, cumque dolores earum eum explicabo facere maiores officiis omnis quae tempora, tenetur voluptates? Adipisci beatae dignissimos dolore excepturi sapiente.</p>`,
    created_at: '2012-01-19 23:59'
}
</script>

<template>
    <div class="overflow-y-auto space-y-3">
        <PostItem v-for="post of posts" :key="post.id" :post="post" @openEditModal="openEditModal"/>
        <PostEditModal :post="editPost" v-model="showEditModal"/>
    </div>
</template>

<style scoped>

</style>