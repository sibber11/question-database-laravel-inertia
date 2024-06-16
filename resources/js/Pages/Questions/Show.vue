<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {MdPreview} from "md-editor-v3";

const props = defineProps({
    model: Object,
});
</script>

<template>
    <AuthenticatedLayout>
      <div class="col-span-2 text-lg">
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

      <div v-if="model.description" class="col-span-2 mt-8">
        <label class="font-bold">Description: </label>
        <MdPreview :model-value="model.description"/>
      </div>

      <div v-if="model.answer" class="col-span-2 mt-8">
        <label class="font-bold">Answer: </label>
        <MdPreview :model-value="model.answer"/>
      </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
