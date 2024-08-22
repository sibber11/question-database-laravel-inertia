<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {computed, onMounted} from "vue";
import SelectInput from "@/Components/SelectInput.vue";
import {MdEditor} from 'md-editor-v3';
import Vue3TagsInput from 'vue3-tags-input';

const props = defineProps({
  model: Object,
  semesters: Object,
  courses: Object,
  chapters: Object,
  semester_id: [String, Number],
  course_id: [String, Number],
  tags: Object,
  chapter_id: [String, Number],
})

const form = useForm({
  title: '',
  semester_id: props.semester_id,
  course_id: props.course_id,
  chapter_id: props.chapter_id,
  description: '',
  answer: '',
  tags: '',
})

function submit() {
  if (props.model) {
    form.patch(route('questions.update', props.model))
  } else {
    form.post(route('questions.store'),{
      onSuccess: ()=>{
        form.title = '';
        form.description = '';
        form.answer = '';
        form.tags = '';
      }
    })
  }
}

const coursesOfSemester = computed(function () {
  if (form.semester_id === null) return props.courses.data;
  return props.courses.data.filter(item => item.semester_id == form.semester_id)
})

const chapterOfCourse = computed(function () {
  if (form.course_id === null) return props.chapters.data;
  return props.chapters.data.filter(item => item.course_id == form.course_id)
})

onMounted(function () {
  setTimeout(() => {
    if (props.model) {
      form.title = props.model.title;
      form.semester_id = props.model.semester_id;
      form.course_id = props.model.course_id;
      form.chapter_id = props.model.chapter_id;
      form.topic_id = props.model.topic_id;
      form.description = props.model.description ?? '';
      form.answer = props.model.answer ?? '';
      form.tags = props.tags;
    }
  }, 100)
})


</script>

<template>
  <Head title="Dashboard"/>

  <AuthenticatedLayout>
    <form class="space-y-6" @submit.prevent="submit">
      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
        </Transition>
      </div>
      <div>
        <InputLabel for="title" value="Title"/>

        <TextInput
          id="title"
          v-model="form.title"
          class="mt-1 block w-full"
          required
          type="text"
        />

        <InputError :message="form.errors.title" class="mt-2"/>
      </div>

      <div>
        <InputLabel for="semester_id" value="Semester"/>

        <SelectInput
          id="semester_id"
          v-model="form.semester_id"
          class="mt-1 block w-full"
          required
        >
          <option v-for="model in semesters.data" :value="model.id">
            {{ model.label }}
          </option>
        </SelectInput>

        <InputError :message="form.errors.semester_id" class="mt-2"/>
      </div>

      <div>
        <InputLabel for="course_id" value="Course"/>

        <SelectInput
          id="course_id"
          v-model="form.course_id"
          class="mt-1 block w-full"
          required
        >
          <option v-for="model in coursesOfSemester" :value="model.id">
            {{ model.label }}
          </option>
        </SelectInput>

        <InputError :message="form.errors.course_id" class="mt-2"/>
      </div>

      <div>
        <InputLabel for="chapter_id" value="Chapter"/>

        <SelectInput
          id="chapter_id"
          v-model="form.chapter_id"
          class="mt-1 block w-full"
          required
        >
          <option v-for="model in chapterOfCourse" :value="model.id">
            {{ model.label }}
          </option>
        </SelectInput>

        <InputError :message="form.errors.chapter_id" class="mt-2"/>
      </div>

      <div>
        <InputLabel for="tags" value="Tags"/>

        <div>
          <Vue3TagsInput
            id="tags"
            @on-tags-changed="t => form.tags = t"
            :tags="tags"
          />
        </div>

        <InputError :message="form.errors.tags" class="mt-2 mb-2"/>
      </div>

      <div>
        <InputLabel for="chapter_id" value="Description"/>

        <MdEditor v-model="form.description" :preview="false" language="en-US" noUploadImg />

        <InputError :message="form.errors.description" class="mt-2"/>
      </div>

      <div>
        <InputLabel class="mb-2" for="answer" value="Answer"/>

        <MdEditor noUploadImg v-model="form.answer" :preview="false" language="en-US"/>

        <InputError :message="form.errors.answer" class="mt-2"/>
      </div>


      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
        </Transition>
      </div>
    </form>
  </AuthenticatedLayout>
</template>
