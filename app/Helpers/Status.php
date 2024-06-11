<?php

class Status
{
    public static function show($model, $size = 24)
    {
        if($model->trashed()){
            return "<i class='status-icon text-danger material-icons-round fs-3'>circle</i>";
        }else{
            return "<i class='status-icon text-success material-icons-round fs-3'>circle</i>";
        }
    }
}
