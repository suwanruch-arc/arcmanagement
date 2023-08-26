<?php

class Status
{
    public function show($status, $size = 24)
    {
        switch ($status) {
            case 'active':
                $status = "<span style='width:{$size}px;height:{$size}px;' class='text-success' data-feather='check-circle'></span>";
                break;
            case 'inactive':
                $status = "<span style='width:{$size}px;height:{$size}px;' class='text-danger' data-feather='x-circle'></span>";
                break;
        }
        return $status;
    }
}
