<?php

namespace App\Traits;

trait DataTableTrait
{
    public function getData($query, $limit, $offset, $search = null)
    {
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('contect_number', 'like', '%' . $search . '%');
            });
        }

        return $query->offset($offset)->limit($limit)->get();
    }

    public function renderData()
    {
    }
}
