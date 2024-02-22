<script setup>
defineProps({
    avatar: String,
    name: String
})
</script>

<template>
    <div class="mb-3 hover:bg-gray-700 cursor-pointer">
        <div class="flex items-center gap-3 p-4">
            <img :src="avatar" :alt="avatar" class="w-[48px] rounded-full border">
            <div>
                <h3 class="font-medium text-sm text-gray-700 dark:text-gray-300">{{ name }}</h3>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>