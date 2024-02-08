<script setup>
import TextInput from "@/Components/TextInput.vue";
import FollowingItem from "@/Components/app/FollowingItem.vue";
import {ref} from "vue";

const search = ref('');
</script>

<template>
    <TextInput :model-value="search" placeholder="Type to search" class="w-full mt-4"/>
    <div class="mt-6 h-[500px] lg:flex-1 overflow-y-auto">
        <div v-if="false" class="text-gray-400 text-center px-3">You don't have any follower yet!</div>
        <div v-else>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
            <FollowingItem avatar="images/profile.png" name="Michel Doe"/>
        </div>
    </div>
</template>

<style scoped>

</style>