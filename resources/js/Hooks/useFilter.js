import qs from "qs";
import {router} from "@inertiajs/vue3";
import {ref, watch} from "vue";

// import debounce from 'lodash.debounce';


/**
 * Parses the query string from the window location and returns the parsed object.
 * @returns {Object} The parsed query object.
 */
export function parseQuery() {
  return qs.parse(window.location.search, {ignoreQueryPrefix: true});
}

/**
 * reloads the page with filters.
 * @param search
 * @param searchField
 * @param query
 */
export function getItems(search, searchField, query) {
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

/**
 * Custom hook for performing search filtering.
 *
 * @param {string} field - The field to filter on.
 * @returns {Object} - An object containing the search value and search field.
 */
export function useSearchFilter(field = '') {
  // Initialize the query object with the parsed query from the window location
  const query = ref(parseQuery());

  // Initialize the search field with the provided field parameter
  const searchField = ref(field);

  // Initialize the search value with an empty string
  let value = '';

  // If the query object has a filter and the search field is not empty,
  // assign the value of the search field from the query object to the value variable
  if (query.value.filter && searchField.value !== '') {
    value = query.value.filter[searchField.value];
  }

  // Initialize the search value with the value variable
  const search = ref(value);

  // Perform the search by field with debounce of 250ms
  const performSearchByField = (reParse = true) => {
    // If the search field is empty, return
    if (searchField.value === '') return;

    // If reParse is true, reparse the query string
    if (reParse) {
      query.value = parseQuery();
    }

    getItems(search.value, searchField.value, query);
  };

  // Watch for changes in the search field
  watch(searchField, (value, oldValue) => {
    // If the search value is empty, return
    if (search.value === '') return;

    // Remove the old search field from the query object
    search.value = '';
    query.value = parseQuery();
    if (query.value.filter !== undefined) {
      delete query.value.filter[oldValue];
    }

    // Perform the search by field without re-parsing the query string
    performSearchByField(false);
  });

  // Watch for changes in the search value
  watch(search, performSearchByField);

  // Return an object containing the search value and search field
  return {search, searchField}
}

/**
 * Performs the status filter based on the search value and search field.
 * @param {string} search - The search value.
 * @param {string} searchField - The search field.
 */
export function performStatusFilter(search, searchField) {
  // If the search field or search value is empty, return
  if (searchField === '' || search === '') return;

  // Initialize the query object
  const query = ref({});

  getItems(search, searchField, query);
}
