<script setup>
import SearchableTable from "@/Components/SearchableTable.vue";

const columns = [
  {label: 'ID', field: 'id', isKey: true, sortable: true, width: '5%'},
  {label: 'Name', field: 'name', sortable: true},
  {label: 'Semester', field: 'semester_id', sortable: true, display: row => row.semester?.name ?? '-'},
  {label: 'Course',field: 'course_id', sortable: true, display: row => row.course?.name ?? '-'},
  {label: 'Actions', field: 'actions', width: '12%'},
]

</script>
<template>
  <SearchableTable :columns="columns"/>
</template>

