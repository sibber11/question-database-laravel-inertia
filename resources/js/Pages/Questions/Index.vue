<script setup>
import SearchableTable from "@/Components/SearchableTable.vue";
import {useSearchFilter} from "@/Hooks/useFilter.js";
import SelectInput from "@/Components/SelectInput.vue";
import {Link} from "@inertiajs/vue3";

const columns = [
  {label: 'ID', field: 'id', isKey: true, sortable: true, width: '5%'},
  {label: 'Title', field: 'title', sortable: true},
  {label: 'Semester', sortable: true, display: row => row.semester?.name ?? '-'},
  {label: 'Course', sortable: true, display: row => row.course?.name ?? '-'},
  {label: 'Chapter', sortable: true, display: row => row.chapter?.name ?? '-'},
  {label: 'Actions', field: 'actions', width: '10%'},
];

const props = defineProps({
  semesters: Object,
  courses: Object,
  chapters: Object,
  topics: Object,
});

const {search: searchSemester} = useSearchFilter('semester_id');
const {search: searchCourse} = useSearchFilter('course_id');
const {search: searchChapter} = useSearchFilter('chapter_id');
const {search: searchTopic} = useSearchFilter('topic_id');

</script>

<template>
  <SearchableTable :columns="columns">
    <div class="grid grid-cols-3">
      <!--            <SelectInput v-model="searchSemester" :options="semesters?.data"/>-->
      <SelectInput v-model="searchCourse" :options="courses?.data"/>
      <SelectInput v-model="searchChapter" :options="chapters?.data"/>
      <SelectInput v-model="searchTopic" :options="topics?.data"/>
    </div>
    <template v-slot:title="{value}">
      <Link :href="route('questions.show', value.id)" class="font-bold text-purple-600">{{ value.title }}</Link>
    </template>
  </SearchableTable>
</template>
