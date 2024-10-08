<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {onMounted} from "vue";
import SelectInput from "@/Components/SelectInput.vue";

const props = defineProps({
  model: Object,
  semesters: Object
})

onMounted(function () {
  if (props.model) {
    form.name = props.model.name;
    form.semester_id = props.model.semester_id;
  }
})

const form = useForm({
  name: '',
  semester_id: null,
})

function submit() {
  if (props.model) {
    form.patch(route('courses.update', props.model))
  } else {
    form.post(route('courses.store'))
  }
}

</script>

<template>
  <Head title="Dashboard"/>

  <AuthenticatedLayout>
    <form class="mt-6 space-y-6" @submit.prevent="submit">
      <div>
        <InputLabel for="name" value="Name"/>

        <TextInput
          id="name"
          v-model="form.name"
          autocomplete="name"
          autofocus
          class="mt-1 block w-full"
          required
          type="text"
        />

        <InputError :message="form.errors.name" class="mt-2"/>
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
