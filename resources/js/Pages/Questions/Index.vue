<script setup>
import SearchableTable from "@/Components/SearchableTable.vue";
import {useSearchFilter} from "@/Hooks/useFilter.js";
import SelectInput from "@/Components/SelectInput.vue";
import {Link} from "@inertiajs/vue3";

const columns = [
  {label: 'ID', field: 'id', isKey: true, sortable: true, width: '5%'},
  {label: 'Title', field: 'title'},
  {label: 'Course', field: 'course_id', sortable: true, display: row => row.course?.name ?? '-'},
  {label: 'Chapter', field:'chapter_id', sortable: true, display: row => row.chapter?.name ?? '-'},
  {label: 'Tags', field:'tags', sortable: false},
  {label: 'Actions', field: 'actions', width: '12%'},
];

const props = defineProps({
  semesters: Object,
  courses: Object,
  chapters: Object,
});

const {search: hasAnswer} = useSearchFilter('has_answer');
const {search: searchChapter} = useSearchFilter('chapter_id');

const hasAnswers = [
  {label: 'Has Answer', id: true},
  {label: 'No Answer', id: false},
]

</script>

<template>
  <SearchableTable :columns="columns">
    <template #buttons>
      <Link :href="route('random-question')" class="btn btn-primary">Random Question</Link>
    </template>
    <div class="flex flex-wrap justify-end gap-4">
      <SelectInput v-model="hasAnswer" :options="hasAnswers"/>
      <SelectInput v-model="searchChapter" :options="chapters?.data" placeholder="filter by chapter"/>
    </div>
    <template v-slot:title="{value}">
      <Link :href="route('questions.show', value.id)" class="font-bold text-slate-700">{{ value.title }}</Link>
    </template>
    <template v-slot:tags="{value}">
      <div v-if="value.tags.length > 0" class="flex gap-2 flex-wrap items-center justify-end md:justify-start">
        <template v-for="tag in value.tags">
          <div class="py-1 px-2 bg-gray-200 rounded">{{ tag.name.en }}</div>
        </template>
      </div>
    </template>
  </SearchableTable>
</template>
