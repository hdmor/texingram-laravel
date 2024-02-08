<script setup>
import TextInput from "@/Components/TextInput.vue";
import GroupItem from "@/Components/app/GroupItem.vue";
import {ref} from "vue";

const search = ref('');
</script>

<template>
    <TextInput :model-value="search" placeholder="Type to search" class="w-full mt-4"/>
    <div class="mt-6 h-[500px] lg:flex-1 overflow-y-auto">
        <div v-if="false" class="text-gray-400 text-center px-3">You aren't joined to any groups</div>
        <div v-else>
            <GroupItem image="images/profile.png" title="Group item #1"
                       description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."/>
            <GroupItem image="images/profile.png" title="Group item #1"
                       description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."/>
            <GroupItem image="images/profile.png" title="Group item #1"
                       description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."/>
            <GroupItem image="images/profile.png" title="Group item #1"
                       description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."/>
            <GroupItem image="images/profile.png" title="Group item #1"
                       description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."/>
            <GroupItem image="images/profile.png" title="Group item #1"
                       description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."/>
            <GroupItem image="images/profile.png" title="Group item #1"
                       description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."/>
            <GroupItem image="images/profile.png" title="Group item #1"
                       description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."/>
            <GroupItem image="images/profile.png" title="Group item #1"
                       description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."/>
        </div>
    </div>
</template>

<style scoped>

</style>