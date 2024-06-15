<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import Vue3TableLite from "vue3-table-lite";
import performSort, {sortable} from "@/Hooks/useSort.js";
import TextInput from "@/Components/TextInput.vue";
import useSearch from "@/Hooks/useSearch.js";
import Pagination from "@/Components/Pagination.vue";


const props = defineProps({
    models: Object
})

const columns = [
    {label: 'ID', field: 'id', isKey: true, sortable: true, width: '5%'},
    {label: 'Name', field: 'name', sortable: true},
    {label: 'Actions', field: 'actions', width: '10%'},
];

const searchValue = useSearch();

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
                <Link :href="route('semesters.create')" class="btn btn-primary">Create</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="py-4 flex justify-end">
                            <TextInput v-model="searchValue" placeholder="search"/>
                        </div>
                        <Vue3TableLite
                            :columns="columns"
                            :rows="models.data"
                            :sortable="sortable()"
                            has-checkbox
                            is-hide-paging is-slot-mode
                            @do-search="performSort">
                            <template v-slot:actions="data">
                                <div class="flex gap-4">
                                    <Link :href="route('semesters.edit', data.value.id)"
                                          class="btn btn-primary">
                                        Edit
                                    </Link>
                                    <Link :href="route('semesters.destroy', data.value.id)" as="button"
                                          class="btn btn-danger"
                                          method="delete">
                                        Delete
                                    </Link>
                                </div>
                            </template>
                        </Vue3TableLite>
                        <Pagination :meta="models.meta"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
