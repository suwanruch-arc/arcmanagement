<?php

class Status
{
    public function show($status, $size = 24)
    {
        switch ($status) {
            case 'active':
                $status = "<i class='status-icon text-success si-check-circle'></i>";
                break;
            case 'inactive':
                $status = "<i class='status-icon text-danger si-x-circle'></i>";
                break;
        }
        return $status;
    }
}
