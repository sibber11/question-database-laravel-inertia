<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {MdPreview} from "md-editor-v3";
import {currentRoute} from "@/Hooks/helpers.js";
import {Link, router} from "@inertiajs/vue3";
import {onMounted, onUnmounted} from "vue";

const props = defineProps({
  model: Object,
  next: [String, Number],
  prev: [String, Number],
});

let startx;
let starty;

const touchListener = function (event) {
  if (event.touches.length === 1) {
    //just one finger touched
    startx = event.touches.item(0).clientX;
    starty = event.touches.item(0).clientY;
  } else {
    //a second finger hit the screen, abort the touch
    startx = null;
  }
};

const touchEndListener = function (event) {
  let offset = 100;//at least 100px are a swipe
  if (startx) {
    //the only finger that hit the screen left it
    let endx = event.changedTouches.item(0).clientX;

    if (endx > startx + offset) {
      //a left -> right swipe
      if (props.prev)
        router.get(route('questions.show', props.prev))
    }
    if (endx < startx - offset) {
      //a right -> left swipe
      if (props.next)
        router.get(route('questions.show', props.next))
    }
  }
  // if (starty) {
  //
  //   let endy = event.changedTouches.item(0).clientY;
  //
  //   if (endy > starty + offset) {
  //     //a top -> bottom swipe
  //     console.log('s')
  //     if (props.prev)
  //       router.get(route('questions.show', props.prev))
  //   }
  //   if (endy < starty - offset) {
  //     //a bottom -> top swipe
  //     if (props.next)
  //       router.get(route('questions.show', props.next))
  //   }
  // }
}

onMounted(() => {
  window.addEventListener("touchstart", touchListener);
  window.addEventListener("touchend", touchEndListener);
})

onUnmounted(() => {
  window.removeEventListener("touchstart", touchListener);
  window.removeEventListener("touchend", touchEndListener);
})

</script>

<template>
  <AuthenticatedLayout>
    <template #buttons>
      <div class="flex flex-wrap gap-4 ml-4 justify-end">
        <Link v-if="prev" :href="route(currentRoute('show'), prev)" class="btn btn-primary">Previous</Link>
        <Link :href="route('questions.edit', model.id)" class="btn btn-secondary">Edit</Link>
        <Link v-if="!prev && !next" :href="route('random-question')" class="btn bg-green-600">Random</Link>
<!--        <Link :href="route(currentRoute('index'))" class="btn btn-primary">Back</Link>-->
        <Link v-if="next" :href="route(currentRoute('show'), next)" class="btn btn-primary">Next</Link>
      </div>
      </template>
      <div class="space-y-2">
        <div class=" text-lg">
          <label class="font-bold">Title: </label>
          <span>{{ model.title }}</span>
        </div>

      <div v-if="model.description" class="-mx-4">
        <!-- <label class="font-bold">Description: </label> -->
        <MdPreview :model-value="model.description" language="en-US"/>
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

    <div v-if="model.answer" class="col-span-2 mt-4 p-4 border rounded shadow">
      <label class="font-bold">Answer: </label>
      <MdPreview :model-value="model.answer"/>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>
