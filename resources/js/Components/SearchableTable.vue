<script setup>

import performSort, {sortable} from "@/Hooks/useSort.js";
import Vue3TableLite from "vue3-table-lite";
import SearchInput from "@/Components/SearchInput.vue";
import Actions from "@/Components/Actions.vue";
import Pagination from "@/Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {usePage} from "@inertiajs/vue3";
import {computed, useSlots} from "vue";

const props = defineProps({
    columns: Array,
    view: Boolean,
})
const models = computed(() => usePage().props.models);
console.log(useSlots())
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-center">
            <SearchInput/>
            <slot></slot>
        </div>
        <Vue3TableLite
            :columns="columns"
            :rows="models.data"
            :sortable="sortable()"
            has-checkbox
            is-hide-paging is-slot-mode
            @do-search="performSort">
            <template #actions="data">
                <Actions :data="data" :view="view"/>
            </template>
            <template v-slot:[slot]="{value}" v-for="(_,slot) in $slots">
                <slot :name="slot" :value="value" v-if="slot != 'default'"/>
            </template>
        </Vue3TableLite>
        <Pagination :meta="models.meta"/>
    </AuthenticatedLayout>
</template>
