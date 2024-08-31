<script setup>

const props = defineProps({
  columns: Object,
  rows: Object,
})

</script>

<template>
  <div class="lite-table">
    <table>
      <thead class="hidden md:table-header-group">
      <tr>
        <th v-for="col in columns" :class="col.headerClass">
          {{ col.label }}
        </th>
      </tr>
      </thead>
      <tbody class="space-y-4">
      <tr v-for="row in rows" class="flex flex-col md:table-row text-right md:text-left">
        <td v-for="col in columns" :class="col.rowClass" :data-column="col.label">
          <slot v-if="$slots[col.field]" :name="col.field" :value="row">&nbsp;</slot>
          <template v-else-if="col.display">
            {{ col.display(row) }}
          </template>
          <template v-else>
            {{ row[col.field] }}
          </template>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.lite-table {
  border-collapse: collapse;
  width: 100%;
  overflow: auto;
}

.lite-table table {
  border-collapse: collapse;
  width: 100%;
  overflow: auto;
}

.lite-table thead {
  background: #0c0c0c;
  color: white;
}

.lite-table th {
  padding: 0.5rem 0;
  border: 1px solid #fff;
}

.lite-table th {
  border-left: 1px solid #000;
}

.lite-table th:last-child {
  border-right: 1px solid #000;
}

.lite-table td {
  @apply p-2 border border-b-0 md:border-b last:border-b;
}

@media screen and (max-width: 769px) {
  .lite-table td:before {
    display: block;
    float: left;
    content: attr(data-column);
    text-align: left;
  }
}

</style>
