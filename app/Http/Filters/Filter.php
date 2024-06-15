<?php

namespace App\Http\Filters;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Spatie\QueryBuilder\AllowedFilter;

abstract class Filter implements Arrayable, Jsonable, JsonSerializable
{
    protected array $fields = [];

    public function __construct()
    {
        $this->make();
    }

    abstract public function make(): void;

    public function fields(): array
    {
        return array_map(function ($arr) {
            return $arr['field'];
        }, $this->fields);
    }

    public function toJson($options = 0): bool|string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'fields' => array_map(function ($arr) {
                if ($arr['field'] instanceof AllowedFilter) {
                    $arr['field'] = $arr['field']->getName();
                }

                return $arr;
            }, $this->fields),
        ];
    }

    /**
     * Generate a text field
     */
    protected function text($field, $placeholder = null, $extra = []): void
    {
        $this->base($field, $placeholder, $extra);
    }

    /**
     * make e filter field.
     */
    private function base(string|AllowedFilter $field, $placeholder = null, $extra = []): void
    {
        //if placeholder is passed translate it.
        if ($placeholder) {
            $placeholder = __($placeholder);
        } //else generate the placeholder
        else {
            $placeholder = $this->getPlaceholder($field);
        }

        // add filter to the field if not null
        $item = [
            'field' => $field,
            'placeholder' => $placeholder,
            ...$extra,
        ];
        $this->fields[] = $item;

    }

    /**
     * Generate placeholder for the field
     */
    private function getPlaceholder($field): string
    {
        return __(':Field', ['field' => $this->getFieldName($field)]);
    }

    /**
     * Get the field name
     */
    private function getFieldName(string|AllowedFilter $field): string
    {
        if ($field instanceof AllowedFilter) {
            return $field->getName();
        } else {
            return $field;
        }
    }

    /**
     * Generate a remote select field
     */
    protected function remote($field, $placeholder = null, $route_name = null, $extra = []): void
    {
        $this->base($field, $placeholder, ['remote' => true, 'isSelect' => true, 'route_name' => $route_name, ...$extra]);
    }

    /**
     * Generate a select field
     * if options are not passed it will generate a select field with active and inactive options
     */
    protected function select($field, $options = [], $placeholder = null, $extra = []): void
    {
        if (empty($options)) {
            $options = [
                ['id' => true, 'value' => __('Active')],
                ['id' => false, 'value' => __('Inactive')],
            ];
        }
        $this->base($field, $placeholder, ['isSelect' => true, 'options' => $options, ...$extra]);
    }
}
