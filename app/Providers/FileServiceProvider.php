<?php

namespace App\Providers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public static function store($file, $path_file, $id, $table,  $field = 'image')
    {
        $originalNameFile = $file->getClientOriginalName();
        $typeFile = $file->getClientMimeType();
        $sizeFile = $file->getSize();
        $pathFile = $path_file;

        $resultFile = Storage::disk('public')->put($pathFile, $file);

        $nameFile = basename($resultFile);

        $insertedFile = File::create([
            'name' => $nameFile,
            'origin_name' => $originalNameFile,
            'type' => $typeFile,
            'size' => $sizeFile,
            'path' => $pathFile,
            'table_name' => $table,
            'table_id' => $id,
            'table_field' => $field,
            'status' => 'active',
        ]);

        return $insertedFile;
    }

    public static function update($file, $path_file, $id, $table, $field = 'image')
    {
        $deactiveFile = File::where([
            'table_id' => $id,
            'table_name' => $table,
            'table_field' => $field,
        ])->update([
            'status' => 'inactive',
        ]);

        self::store($file, $path_file, $id, $table, $field);

        return $deactiveFile;
    }
}
