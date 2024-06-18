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
                if (!isset($column['ref'])) {
                    $query = $query->orWhere($column['field'], 'LIKE', "%{$search}%");
                } else {
                    $table = $column['ref'];
                    $fields = $column['field'];
                    $query = $query->orWhereHas($table, function ($query) use ($fields, $search) {
                        $query = $query->where(function ($query) use ($fields, $search) {
                            foreach ($fields as $field) {
                                $query = $query->orWhere($field, 'LIKE', "%{$search}%");
                            }
                        });
                    });
                }
            }
        }

        return $query;
    }
}