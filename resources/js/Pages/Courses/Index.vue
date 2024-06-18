<script setup>
import SearchableTable from "@/Components/SearchableTable.vue";

const columns = [
  {label: 'ID', field: 'id', isKey: true, sortable: true, width: '5%'},
  {label: 'Name', field: 'name', sortable: true},
  {label: 'Semester', field: 'semester_id', sortable: true, display: row => row.name},
  {label: 'Actions', field: 'actions', width: '10%'},
];

</script>

<template>
  <SearchableTable :columns="columns"/>
</template>
