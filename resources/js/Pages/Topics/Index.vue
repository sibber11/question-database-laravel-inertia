<script setup>
import SearchableTable from "@/Components/SearchableTable.vue";

const columns = [
  {label: 'ID', field: 'id', isKey: true, sortable: true, width: '5%'},
  {label: 'Name', field: 'name', sortable: true},
  {label: 'Semester', sortable: true, display: row => row.semester?.name ?? '-'},
  {label: 'Course', sortable: true, display: row => row.course?.name ?? '-'},
  {label: 'Chapter', sortable: true, display: row => row.chapter?.name ?? '-'},
  {label: 'Actions', field: 'actions', width: '10%'},
];

</script>

<template>
  <SearchableTable :columns="columns"/>
</template>
