<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <div class="space-y-4">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded">
            <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="max-w-xl"/>
        </div>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded">
            <UpdatePasswordForm class="max-w-xl"/>
        </div>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded">
            <DeleteUserForm class="max-w-xl"/>
        </div>
    </div>
</template>
