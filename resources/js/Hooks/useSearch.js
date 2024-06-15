import {onMounted, ref, watch} from 'vue';
import {router} from '@inertiajs/vue3'
import {parseQuery} from "@/Hooks/useSort.js";

/**
 * reloads the page with filters.
 * @param search
 * @param searchField
 * @param query
 */
function getItems(search, searchField, query) {
    // If the search value is not empty, add the search field and search value to the query object
    if (search !== null && search !== undefined && search !== '') {
        query.value.filter = {
            ...query.value.filter,
            [searchField]: search,
        }
    } else {
        // If the search value is empty, remove the search field from the query object
        delete query.value.filter[searchField];
    }
    // check if page is set
    if (query.value.page !== undefined) {
        delete query.value.page;
    }
    router.get(route(route().current()), query.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}

export function useSearch() {
    const searchValue = ref('');
    const query = ref();

    onMounted(() => {
        query.value = parseQuery();
        searchValue.value = query.q || '';
    });

    const performSearch = () => {
        query.value = parseQuery();
        getItems(searchValue.value, 'q', query);
    };

    watch(searchValue, performSearch);

    return searchValue;
}

export default useSearch;
