<script setup>
defineProps({
    image: String,
    title: String,
    description: String
})
</script>

<template>
    <div class="mb-3 hover:bg-gray-700 cursor-pointer">
        <div class="flex items-start gap-3 p-4">
            <img :src="image" :alt="title" class="w-[48px] rounded-full border">
            <div>
                <h3 class="font-medium text-sm text-gray-700 dark:text-gray-300">{{ title }}</h3>
                <div class="text-sm text-gray-600 dark:text-gray-400">{{ description }}</div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>