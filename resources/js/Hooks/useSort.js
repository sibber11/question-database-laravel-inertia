import qs from 'qs';
import {router} from '@inertiajs/vue3'

function performSort(offset, limit, order, sort) {
  const query = parseQuery();
  let params = {};

  // remove the sort, if none passed
  if (sort === 'none') {
    delete query.sort;
    params = {
      ...query
    }
  } else {
    // add a minus at to beginning of the string if the sort is descending
    const direction = (sort === 'desc' ? '-' : '');
    params = {
      ...query,
      sort: direction + order,
      // perPage: limit
    }
  }

  router.get(route(route().current()), params, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  })
}

export function parseQuery() {
  return qs.parse(window.location.search, {ignoreQueryPrefix: true});
}

export function sortable() {
  const query = parseQuery();
  if (!query.sort) return {};
  const direction = query.sort.includes('-') ? 'desc' : 'asc';
  const sort = query.sort.replace('-', '');

  return {
    order: direction,
    sort: sort,
  }

}

export default performSort;
