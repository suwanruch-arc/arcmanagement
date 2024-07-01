<?php

namespace App\Providers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    public static function store($path, $model, $field = 'file')
    {
        $request = request();
        $file = $request->file($field);

        $originalNameFile = $file->getClientOriginalName();
        $extensionFile = $file->getClientMimeType();
        $sizeFile = $file->getSize();
        $pathFile = $path . '/' . $field;
        $resultFile = Storage::disk('public')->put($pathFile, $file);
        $nameFile = basename($resultFile);
        $id = $model->id;
        $table = $model->getTable();

        $insertedFile = File::create([
            'file_name' => $nameFile,
            'origin_name' => $originalNameFile,
            'extension' => $extensionFile,
            'path' => $pathFile,
            'size' => $sizeFile,
            'table_id' => $id,
            'table_name' => $table,
            'type' => $field,
            'status' => 'active',
        ]);

        return $insertedFile;
    }
}
