<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {MdPreview} from "md-editor-v3";

const props = defineProps({
    model: Object,
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="font-bold">Title: </label>
                            <span>{{ model.title }}</span>
                        </div>
                        <div>
                            <label class="font-bold">Semester: </label>
                            <span>{{ model.semester.name }}</span>
                        </div>
                        <div>
                            <label class="font-bold">Course: </label>
                            <span>{{ model.course.name }}</span>
                        </div>

                        <div>
                            <label class="font-bold">Chapter: </label>
                            <span>{{ model.chapter.name }}</span>
                        </div>
                        <div v-if="model.topic">
                            <label class="font-bold">Topic: </label>
                            <span>{{ model.topic?.name }}</span>
                        </div>

                        <div v-if="model.description" class="col-span-2">
                            <label class="font-bold">Description: </label>
                            <MdPreview :model-value="model.description"/>
                        </div>

                        <div v-if="model.answer" class="col-span-2">
                            <label class="font-bold">Answer: </label>
                            <MdPreview :model-value="model.answer"/>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
