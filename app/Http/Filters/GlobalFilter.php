<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class GlobalFilter extends Filter
{
    protected AllowedFilter $allowedFilter;

    public function __construct(protected array $columns = [])
    {
        $this->generateAllowedFilter($columns);
        parent::__construct();
    }

    public function generateAllowedFilter(array $columns): void
    {
        $this->allowedFilter = AllowedFilter::callback('q', function (Builder $query, $q) use ($columns) {
            // filter the query by the given search value
            // simple where or orWhere for each column for non-relation columns
            $nonRelationColumns = array_filter($columns, fn($column) => !str_contains($column, '.'));
            $query->whereAny($nonRelationColumns, 'LIKE', "%{$q}%")
                ->when(array_search('name', $nonRelationColumns), function (Builder $query) use ($q) {
                    $query->orderByRaw("CASE WHEN name = '{$q}' THEN 1 WHEN name LIKE '{$q}%' THEN 2 ELSE 3 END");
                });

            // orWhereHas for each column for relation columns
            $relationColumns = array_filter($columns, fn($column) => str_contains($column, '.'));
            foreach ($relationColumns as $relationColumn) {
                // explode the relation column to get the relation and the column
                $relationColumn = explode('.', $relationColumn);
                // pop the last element to get the column
                $column = array_pop($relationColumn);
                // implode the remaining elements to get the relation
                $relations = implode('.', $relationColumn);
                $query->orWhereHas($relations, function (Builder $query) use ($column, $q) {
                    $query->where($column, 'LIKE', "%{$q}%");
                });
            }
        });
    }

    public function make(): void
    {
        $this->text($this->allowedFilter, 'Search');
    }
}
