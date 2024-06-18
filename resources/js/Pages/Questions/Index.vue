<script setup>
import SearchableTable from "@/Components/SearchableTable.vue";
import {useSearchFilter} from "@/Hooks/useFilter.js";
import SelectInput from "@/Components/SelectInput.vue";
import {Link} from "@inertiajs/vue3";

const columns = [
  {label: 'ID', field: 'id', isKey: true, sortable: true, width: '5%'},
  {label: 'Title', field: 'title', sortable: true},
  {label: 'Semester', field:'semester_id', sortable: true, display: row => row.semester?.name ?? '-'},
  {label: 'Course', field:'course_id', sortable: true, display: row => row.course?.name ?? '-'},
  {label: 'Chapter', field:'chapter_id', sortable: true, display: row => row.chapter?.name ?? '-'},
  {label: 'Actions', field: 'actions', width: '10%'},
];

const props = defineProps({
  semesters: Object,
  courses: Object,
  chapters: Object,
  topics: Object,
});

// const {search: searchSemester} = useSearchFilter('semester_id');
const {search: hasAnswer} = useSearchFilter('has_answer');
const {search: searchChapter} = useSearchFilter('chapter_id');
const {search: searchTopic} = useSearchFilter('topic_id');

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
    <div class="flex justify-end gap-4">
      <!--            <SelectInput v-model="searchSemester" :options="semesters?.data"/>-->
      <SelectInput v-model="hasAnswer" :options="hasAnswers"/>
      <SelectInput v-model="searchChapter" :options="chapters?.data" placeholder="filter by chapter"/>
      <SelectInput v-model="searchTopic" :options="topics?.data" placeholder="filter by topic"/>
    </div>
    <template v-slot:title="{value}">
      <Link :href="route('questions.show', value.id)" class="font-bold text-slate-700">{{ value.title }}</Link>
    </template>
  </SearchableTable>
</template>
