<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Applies a whitelisted set of filters: filter key => closure.
     * Keeps controllers free of query-building noise.
     *
     * @param  array<string, mixed>  $filters
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach (array_filter($filters, fn ($v) => $v !== null && $v !== '') as $key => $value) {
            $method = 'filter'.str($key)->studly();

            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
            }
        }

        return $query;
    }
}
