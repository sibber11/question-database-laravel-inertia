import {onMounted, ref, watch} from 'vue';
import {parseQuery} from "@/Hooks/useSort.js";
import {getItems} from "@/Hooks/useFilter.js";


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
