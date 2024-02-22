<script setup>

defineProps({
    post: {type: Object},
    displayTime: {
        type: Boolean,
        default: true
    },
    avatarWidth: {
        type: String,
        default: "w-[48px]"
    }
});

</script>

<template>
    <a href="javascript:void(0)">
        <img :src="post.user.avatar_url || '/images/profile.png'" alt="avatar" :class="avatarWidth"
             class="rounded-full border border-2 transition-all hover:border-blue-500">
    </a>
    <div>
        <h4 class="font-bold flex items-center">
            <a href="javascript:void(0)" class="font-medium text-sm text-gray-700 dark:text-gray-300 hover:underline">{{ post.user.name }}</a>
            <template v-if="post.group">
                <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 17l5-5-5-5M6 17l5-5-5-5"/>
                </svg>
                <a href="javascript:void(0)" class="font-medium text-sm text-gray-700 dark:text-gray-300 hover:underline">{{ post.group.name }}</a>
            </template>
        </h4>
        <small v-if="displayTime" class="text-sm text-gray-600 dark:text-gray-400">{{ post.updated_at }}</small>
    </div>
</template>

<style scoped>

</style>