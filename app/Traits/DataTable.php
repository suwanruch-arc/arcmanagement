<?php

namespace App\Traits;

trait DataTable
{
    public static function getData($query, $columns, $map)
    {
        $request = request();
        if ($request->ajax()) {
            $draw = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');
            $order = $request->get('order');
            $search = $request->get('search');

            $totalData = $query->count();

            if ($search['value'] != '') {
                $searchValue = $search['value'];
                foreach ($columns as $column) {
                    if (!isset($column['ref'])) {
                        $query = $query->orWhere($column['data'], 'LIKE', "%{$searchValue}%");
                    } else {
                        list($table, $fields) = explode(':', $column['ref']);
                        $query = $query->orWhereHas($column['data'], function ($query) use ($table, $fields, $searchValue) {
                            $query = $query->where(function ($query) use ($table, $fields, $searchValue) {
                                $fields = explode(',', $fields);
                                foreach ($fields as $field) {
                                    $query = $query->orWhere("{$table}.{$field}", 'LIKE', "%{$searchValue}%");
                                }
                            });
                        });
                    }
                }
            }

            $totalFiltered = $query->count();

            $sortBy = isset($order[0]['column']) ? $columns[$order[0]['column']]['data'] : 'id'; // Default sort by id
            $sortDir = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc'; // Default sort order ascending

            $query = $query->offset($start)->limit($length);

            $fetch = $query->get();

            $data = $fetch->map($map);

            if ($sortDir === 'asc') {
                $data = $data->sortBy($sortBy);
            } else {
                $data = $data->sortByDesc($sortBy);
            }

            echo json_encode([
                'draw' => intval($draw),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ]);
            exit;
        }
    }
}
