<?php

class Status
{
    public function show($status, $size = 24)
    {
        switch ($status) {
            case 'active':
                $status = "<i class='status-icon text-success material-icons-round fs-3'>circle</i>";
                break;
            case 'inactive':
                $status = "<i class='status-icon text-danger material-icons-round fs-3'>circle</i>";
                break;
        }
        return $status;
    }
}
