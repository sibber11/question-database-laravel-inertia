<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SearchableTable from "@/Components/SearchableTable.vue";

const props = defineProps({
    models: Object
})
const columns = [
    {label: 'ID', field: 'id', isKey: true, sortable: true, width: '5%'},
    {label: 'Name', field: 'name', sortable: true},
    {label: 'Semester', field: 'semester', sortable: true, display: row=>row.name},
    {label: 'Actions', field: 'actions', width: '10%'},
];

</script>

<template>
    <AuthenticatedLayout>
        <SearchableTable :columns="columns" :models="models"/>
    </AuthenticatedLayout>
</template>
