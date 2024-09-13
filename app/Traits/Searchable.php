<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $query, array $columns): Builder
    {
        $request = request();
        if ($request->has('search')) {
            $search = $request->get('search');
            foreach ($columns as $column) {
                if (isset($column['ref'])) {
                    $table = $column['ref'];
                    $fields = $column['field'];
                    $withTrashed = $column['withTrashed'] ?? false;

                    if (is_array($fields)) {
                        $query->orWhereHas($table, function (Builder $query) use ($fields, $search, $withTrashed) {
                            $query->where(function (Builder $query) use ($fields, $search, $withTrashed) {
                                if ($withTrashed) {
                                    $query->withTrashed();
                                }
                                foreach ($fields as $field) {
                                    $query->orWhere($field, 'LIKE', "%{$search}%");
                                }
                            });
                            if ($withTrashed) {
                                $query->withTrashed();
                            }
                        });
                    } else {
                        $query->orWhereHas($table, function (Builder $query) use ($fields, $search, $withTrashed) {
                            $query->where($fields, 'LIKE', "%{$search}%");
                            if ($withTrashed) {
                                $query->withTrashed();
                            }
                        });
                    }
                } else {
                    $query->orWhere($column['field'], 'LIKE', "%{$search}%");
                }
            }
        }

        return $query;
    }
}