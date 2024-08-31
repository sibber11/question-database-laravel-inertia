<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import SelectInput from "@/Components/SelectInput.vue";
import {watch} from "vue";
import {Link} from '@inertiajs/vue3';

const props = defineProps({
  semesters: Object,
  courses: Object,
  chapters: Object,
  semester_id: [String, Number],
  course_id: [String, Number],
  chapter_id: [String, Number],
  statistics: Object,
})

const form = useForm({
  semester_id: props.semester_id,
  course_id: props.course_id,
  chapter_id: props.chapter_id,
})

watch(() => form.semester_id, () => {
  router.post(route('session.change-semester-course'), {
    semester_id: form.semester_id,
  })
})

watch(() => form.course_id, () => {
  router.post(route('session.change-semester-course'), {
    course_id: form.course_id,
  })
})

watch(() => form.chapter_id, () => {
  router.post(route('session.change-semester-course'), {
    chapter_id: form.chapter_id,
  })
})

</script>

<template>
  <Head title="Dashboard"/>

  <AuthenticatedLayout>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
      <div class="border p-2 rounded flex flex-wrap gap-4 justify-between items-center">
        <label>Select Semester</label>
        <SelectInput v-model="form.semester_id" :options="semesters?.data"/>
      </div>
      <div class="border p-2 rounded flex flex-wrap gap-4 justify-between items-center">
        <label>Select Course</label>
        <SelectInput v-model="form.course_id" :options="courses?.data"/>
      </div>
      <div class="border p-2 rounded flex flex-wrap gap-4 justify-between items-center">
        <label>Select Chapter</label>
        <SelectInput v-model="form.chapter_id" :options="chapters?.data"/>
      </div>
    </div>
    <hr class="my-4">
    <div class="grid grid-cols-2 gap-4 my-4">
      <Link :href="route('questions.index')" class="p-4 border rounded flex justify-between items-center text-xl shadow">
        <label class="block">Total Questions</label>
        <div>{{statistics.total_questions}}</div>
      </Link>
      <div class="p-4 border rounded flex justify-between items-center text-xl shadow">
        <label class="block">Answers</label>
        <div>{{statistics.answered_questions}}</div>
      </div>
      <div class="p-4 border rounded flex justify-between items-center text-xl shadow">
        <label class="block">Questions</label>
        <div>{{statistics.un_answered_questions}}</div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
