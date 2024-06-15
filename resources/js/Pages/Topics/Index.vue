<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    models: Object
})

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
                <Link :href="route('topics.create')" class="btn btn-primary">Create</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="styled-table">
                            <thead>
                            <tr>
                                <th class="w-16">ID</th>
                                <th>Name</th>
                                <th>Semester</th>
                                <th>Course</th>
                                <th>Chapter</th>
                                <th class="w-32">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="model in models.data">
                                <td class="text-center">{{ model.id }}</td>
                                <td>{{ model.name }}</td>
                                <td>{{ model.semester.name }}</td>
                                <td>{{ model.course.name }}</td>
                                <td>{{ model.chapter.name }}</td>
                                <td class="text-center">
                                    <div class="flex gap-4">
                                        <Link :href="route('topics.edit', model.id)"
                                              class="btn btn-primary">
                                            Edit
                                        </Link>
                                        <Link :href="route('topics.destroy', model.id)" as="button"
                                              class="btn btn-danger"
                                              method="delete">
                                            Delete
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <Pagination :meta="models.meta"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
