<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {MdPreview} from "md-editor-v3";
import {currentRoute} from "@/Hooks/helpers.js";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
  model: Object,
});
</script>

<template>
  <AuthenticatedLayout>
    <template #buttons>
      <div class="space-x-4">
        <Link :href="route('random-question')" class="btn btn-primary">Random Question</Link>
        <Link :href="route(currentRoute('edit'), model.id)" class="btn btn-secondary">Edit</Link>
        <Link :href="route(currentRoute('index'))" class="btn btn-primary">Back</Link>
      </div>
    </template>

    <div class="space-y-2">
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

      <div v-if="model.tags">
        <label class="font-bold">Tags & Years: </label>
        <span class="space-x-2">
          <template v-for="tag in model.tags">
            <span class="py-1 px-2 bg-gray-200 rounded">{{ tag.name.en }}</span>
          </template>
        </span>
      </div>
    </div>

    <div v-if="model.description" class="col-span-2 mt-4 rounded">
      <label class="font-bold">Description: </label>
      <MdPreview :model-value="model.description"/>
    </div>

    <div v-if="model.answer" class="col-span-2 mt-4 p-4 border rounded shadow">
      <label class="font-bold">Answer: </label>
      <MdPreview :model-value="model.answer"/>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>
