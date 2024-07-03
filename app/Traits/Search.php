<?php

namespace App\Traits;

trait Search
{
    public static function getData($query, $columns)
    {
        $request = request();
        if ($request->has('search')) {
            $search = $request->get('search');
            foreach ($columns as $column) {
                if (isset($column['ref'])) {
                    $table = $column['ref'];
                    $fields = $column['field'];
                    $withTrashed = $columns['withTrashed'] ?? false;
                    if (is_array($fields)) {
                        $query = $query->orWhereHas($table, function ($query) use ($fields, $search, $withTrashed) {
                            $query = $query->where(function ($query) use ($fields, $search, $withTrashed) {
                                if ($withTrashed) {
                                    $query = $query->withTrashed();
                                }
                                foreach ($fields as $field) {
                                    $query = $query->orWhere($field, 'LIKE', "%{$search}%");
                                }
                            });
                            if ($withTrashed) {
                                $query = $query->withTrashed();
                            }
                        });
                    } else {
                        $query = $query->orWhereHas($table, function ($query) use ($fields, $search, $withTrashed) {
                            $query = $query->where($fields, 'LIKE', "%{$search}%");
                            if ($withTrashed) {
                                $query = $query->withTrashed();
                            }
                        });
                    }
                } else {
                    $query = $query->orWhere($column['field'], 'LIKE', "%{$search}%");
                }
            }
        }

        return $query;
    }
}