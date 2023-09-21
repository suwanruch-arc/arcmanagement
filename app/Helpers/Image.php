<?php

use App\Models\File;

class Image
{
    public function __construct()
    {
    }

    public static function setAttribute($attrs)
    {
        if (!empty($attrs)) {
            foreach ($attrs as $key => $value) {
                $attr[] = "{$key}='{$value}'";
            }
            $attribute = implode(' ', $attr);
        }

        return $attribute ?? '';
    }

    public static function get($id, $table, $field)
    {
        $file = File::firstWhere(['table_id' => $id, 'table_name' => $table, 'table_field' => $field, 'status' => 'active']);
        if ($file) {
            $image = "{$file->path}/$file->name";
            if (Storage::disk('public')->exists($image)) {
                $type = $file->type;
                $source = base64_encode(Storage::disk('public')->get($image));
                $response = "data:{$type};base64,{$source}";
            }
        }

        return $response ?? '';
    }

    public static function show($id, $table, $attribute = ['id' => 'image'])
    {
        $attr = self::setAttribute($attribute);
        $file = File::firstWhere(['table_id' => $id, 'table_name' => $table, 'table_field' => $attribute['id'], 'status' => 'active']);
        if ($file) {
            $image = "{$file->path}/$file->name";
            if (Storage::disk('public')->exists($image)) {
                $type = $file->type;
                $source = base64_encode(Storage::disk('public')->get($image));
                $attr = self::setAttribute($attribute);
                $response = "<img {$attr} src='data:{$type};base64,{$source}'/>";
            }
        }

        return $response ?? '';
    }
}
