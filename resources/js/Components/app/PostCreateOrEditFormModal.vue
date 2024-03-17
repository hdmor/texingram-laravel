<script setup>
import {computed, ref, watch} from 'vue';
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot,} from '@headlessui/vue';
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import BalloonEditor from "@ckeditor/ckeditor5-build-balloon";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {isImage} from "@/helpers.js";

const editor = BalloonEditor;
const editorConfig = {
    toolbar: ['heading', '|', 'bold', 'italic', '|', 'link', '|', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote']
};

const props = defineProps({
    post: {
        type: Object,
        required: true
    },
    modelValue: Boolean
});

const show = computed({
    get: _ => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

const emit = defineEmits(['update:modelValue'])

const form = useForm({
    id: null,
    body: ''
});

watch(() => props.post, (newValue) => {
    form.id = newValue.id
    form.body = newValue.body
});

function store() {
    form.post(route('posts.store'), {
        preserveScroll: true,
        onSuccess: _ => {
            show.value = false;
            form.reset();
        }
    });
}

function update() {
    form.patch(route('posts.update', props.post.id), {
        preserveScroll: true,
        onSuccess: _ => {
            show.value = false;
            form.reset();
        }
    });
}

const attachments = ref([]);

async function onAttachmentChanged($event) {
    for (const file of $event.target.files) {
        const fileDetails = {
            file,
            url: await readFile(file)
        };
        attachments.value.push(fileDetails)
    }
    $event.target.value = null;
}

async function readFile(file) {
    return new Promise((resolve, reject) => {
        if (isImage(file)) {
            const fileReader = new FileReader();
            fileReader.onload = _ => {
                resolve(fileReader.result)
            };
            fileReader.onerror = _ => reject;
            fileReader.readAsDataURL(file);
        } else resolve(null)
    })
}

const removeAttachment = (attachment) => {
    attachments.value = attachments.value.filter(a => a !== attachment)
}
</script>

<template>
    <teleport to="body">
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" @close="show = false" class="relative z-10">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black/25"/>
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center">
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded bg-white dark:bg-gray-800 shadow p-4 sm:p-8 text-left align-middle shadow-xl transition-all">
                                <DialogTitle as="h3"
                                             class="pb-3 flex justify-between items-center text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-700">
                                    {{ form.id ? 'Edit' : 'Create New' }} Post
                                    <button class="rounded-full hover:bg-black/25 transition p-2" @click="show = false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </DialogTitle>
                                <div class="mt-2">
                                    <div class="flex items-center gap-2 my-3">
                                        <PostUserHeader :post="post" :displayTime="false" avatarWidth="w-[32px]"/>
                                    </div>
                                    <ckeditor :editor="editor" v-model="form.body" :config="editorConfig"
                                              class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></ckeditor>
                                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 my-3">
                                        <template v-for="(attachment, index) of attachments" :key="index">
                                            <div class="group bg-blue-100 aspect-square flex flex-col items-center justify-center gap-4 relative">
                                                <button @click="removeAttachment(attachment)"
                                                        class="opacity-0 group-hover:opacity-100 transition-all w-8 h-8 flex items-center justify-center bg-gray-700 hover:bg-gray-800 rounded absolute right-2 top-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                         stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </button>
                                                <img v-if="isImage(attachment.file)" :src="attachment.url" :alt="attachment.file.name"
                                                     class="aspect-square object-cover w-full h-full">
                                                <template v-else>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                                                         stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path
                                                            d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                                    </svg>
                                                    <small class="text-xs text-center">{{ attachment.file.name }}</small>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="mt-3 flex items-center justify-end gap-2">
                                    <SecondaryButton @click.stop @change="onAttachmentChanged" type="button" class="relative flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                        </svg>
                                        Attachment Files
                                        <input type="file" multiple class="absolute w-full h-full opacity-0 cursor-pointer">
                                    </SecondaryButton>
                                    <PrimaryButton type="button" @click="form.id ? update() : store()" class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                            <polyline points="7 3 7 8 15 8"></polyline>
                                        </svg>
                                        {{ form.id ? 'Update' : 'Save' }}
                                    </PrimaryButton>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>

<style scoped>

</style>