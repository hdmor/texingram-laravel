<script setup>
import {ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import {useForm} from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const form_visibility = ref(false);
const form = useForm({
    body: ''
});

const submit = _ => {
    form.post(route('posts.store'), {
        onSuccess: _ => {
            form.reset();
        }
    });
};
</script>

<template>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded mb-3">
        <TextAreaInput @click="form_visibility = !form_visibility" class="w-full"
                       placeholder="Click here to create new post" rows="1" v-model="form.body"/>
        <div v-show="form_visibility" class="flex justify-between gap-2 mt-3">
            <SecondaryButton>Attach Files</SecondaryButton>
            <PrimaryButton @click="submit">Submit</PrimaryButton>
        </div>
    </div>
</template>

<style scoped>

</style>