<script setup>
import {computed, watch} from 'vue';
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot,} from '@headlessui/vue';
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import BalloonEditor from "@ckeditor/ckeditor5-build-balloon";

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
};

function update() {
    form.patch(route('posts.update', props.post.id), {
        preserveScroll: true,
        onSuccess: _ => {
            show.value = false;
            form.reset();
        }
    });
};
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
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <PrimaryButton type="button" @click="form.id ? update() : store()">
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