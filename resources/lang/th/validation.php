<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'ต้องยอมรับ <u><b>:attribute</b></u>.',
    'accepted_if' => 'ต้องยอมรับ <u><b>:attribute</b></u> เมื่อ <u><b>:other</b></u> มีค่าเป็น <u><b>:value</b></u>.',
    'active_url' => '<u><b>:attribute</b></u> ไม่ใช่ URL ที่ถูกต้อง.',
    'after' => '<u><b>:attribute</b></u> ต้องเป็นวันที่หลัง <u><b>:date</b></u>.',
    'after_or_equal' => '<u><b>:attribute</b></u> ต้องเป็นวันที่หลังหรือเท่ากับ <u><b>:date</b></u>.',
    'alpha' => '<u><b>:attribute</b></u> ต้องประกอบด้วยตัวอักษรเท่านั้น.',
    'alpha_dash' => '<u><b>:attribute</b></u> ต้องประกอบด้วยตัวอักษร ตัวเลข เครื่องหมายขีดกลาง และขีดล่างเท่านั้น.',
    'alpha_num' => '<u><b>:attribute</b></u> ต้องประกอบด้วยตัวอักษรและตัวเลขเท่านั้น.',
    'array' => '<u><b>:attribute</b></u> ต้องเป็นอาเรย์.',
    'before' => '<u><b>:attribute</b></u> ต้องเป็นวันที่ก่อน <u><b>:date</b></u>.',
    'before_or_equal' => '<u><b>:attribute</b></u> ต้องเป็นวันที่ก่อนหรือเท่ากับ <u><b>:date</b></u>.',
    'between' => [
        'numeric' => '<u><b>:attribute</b></u> ต้องอยู่ระหว่าง <u><b>:min</b></u> และ <u><b>:max</b></u>.',
        'file' => '<u><b>:attribute</b></u> ต้องมีขนาด <u><b>:min</b></u> ถึง <u><b>:max</b></u> กิโลไบต์.',
        'string' => '<u><b>:attribute</b></u> ต้องมีความยาว <u><b>:min</b></u> ถึง <u><b>:max</b></u> ตัวอักษร.',
        'array' => '<u><b>:attribute</b></u> ต้องมี <u><b>:min</b></u> ถึง <u><b>:max</b></u> รายการ.',
    ],
    'boolean' => 'ฟิลด์ <u><b>:attribute</b></u> ต้องเป็น true หรือ false.',
    'confirmed' => 'การยืนยัน <u><b>:attribute</b></u> ไม่ตรงกัน.',
    'current_password' => 'รหัสผ่านไม่ถูกต้อง.',
    'date' => '<u><b>:attribute</b></u> ไม่ใช่วันที่ที่ถูกต้อง.',
    'date_equals' => '<u><b>:attribute</b></u> ต้องเป็นวันที่เท่ากับ <u><b>:date</b></u>.',
    'date_format' => '<u><b>:attribute</b></u> ไม่ตรงกับรูปแบบ <u><b>:format</b></u>.',
    'declined' => '<u><b>:attribute</b></u> ต้องถูกปฏิเสธ.',
    'declined_if' => '<u><b>:attribute</b></u> ต้องถูกปฏิเสธเมื่อ <u><b>:other</b></u> มีค่าเป็น <u><b>:value</b></u>.',
    'different' => '<u><b>:attribute</b></u> และ <u><b>:other</b></u> ต้องไม่เหมือนกัน.',
    'digits' => '<u><b>:attribute</b></u> ต้องเป็น <u><b>:digits</b></u> หลัก.',
    'digits_between' => '<u><b>:attribute</b></u> ต้องอยู่ระหว่าง <u><b>:min</b></u> และ <u><b>:max</b></u> หลัก.',
    'dimensions' => '<u><b>:attribute</b></u> มีขนาดภาพไม่ถูกต้อง.',
    'distinct' => 'ฟิลด์ <u><b>:attribute</b></u> มีค่าซ้ำ.',
    'email' => '<u><b>:attribute</b></u> ต้องเป็นที่อยู่อีเมลที่ถูกต้อง.',
    'ends_with' => '<u><b>:attribute</b></u> ต้องสิ้นสุดด้วยหนึ่งในค่าต่อไปนี้: <u><b>:value</b></u>s.',
    'enum' => 'ค่าที่เลือกสำหรับ <u><b>:attribute</b></u> ไม่ถูกต้อง.',
    'exists' => 'ค่าที่เลือกสำหรับ <u><b>:attribute</b></u> ไม่ถูกต้อง.',
    'file' => '<u><b>:attribute</b></u> ต้องเป็นไฟล์.',
    'filled' => 'ฟิลด์ <u><b>:attribute</b></u> ต้องมีค่า.',
    'gt' => [
        'numeric' => '<u><b>:attribute</b></u> ต้องมากกว่า <u><b>:value</b></u>.',
        'file' => '<u><b>:attribute</b></u> ต้องมากกว่า <u><b>:value</b></u> กิโลไบต์.',
        'string' => '<u><b>:attribute</b></u> ต้องมากกว่า <u><b>:value</b></u> ตัวอักษร.',
        'array' => '<u><b>:attribute</b></u> ต้องมีมากกว่า <u><b>:value</b></u> รายการ.',
    ],
    'gte' => [
        'numeric' => '<u><b>:attribute</b></u> ต้องมากกว่าหรือเท่ากับ <u><b>:value</b></u>.',
        'file' => '<u><b>:attribute</b></u> ต้องมากกว่าหรือเท่ากับ <u><b>:value</b></u> กิโลไบต์.',
        'string' => '<u><b>:attribute</b></u> ต้องมากกว่าหรือเท่ากับ <u><b>:value</b></u> ตัวอักษร.',
        'array' => '<u><b>:attribute</b></u> ต้องมี <u><b>:value</b></u> รายการหรือมากกว่า.',
    ],
    'image' => '<u><b>:attribute</b></u> ต้องเป็นภาพ.',
    'in' => 'ค่าที่เลือกสำหรับ <u><b>:attribute</b></u> ไม่ถูกต้อง.',
    'in_array' => 'ฟิลด์ <u><b>:attribute</b></u> ไม่มีอยู่ใน <u><b>:other</b></u>.',
    'integer' => '<u><b>:attribute</b></u> ต้องเป็นจำนวนเต็ม.',
    'ip' => '<u><b>:attribute</b></u> ต้องเป็น IP address ที่ถูกต้อง.',
    'ipv4' => '<u><b>:attribute</b></u> ต้องเป็น IPv4 address ที่ถูกต้อง.',
    'ipv6' => '<u><b>:attribute</b></u> ต้องเป็น IPv6 address ที่ถูกต้อง.',
    'json' => '<u><b>:attribute</b></u> ต้องเป็น JSON string ที่ถูกต้อง.',
    'lt' => [
        'numeric' => '<u><b>:attribute</b></u> ต้องน้อยกว่า <u><b>:value</b></u>.',
        'file' => '<u><b>:attribute</b></u> ต้องน้อยกว่า <u><b>:value</b></u> กิโลไบต์.',
        'string' => '<u><b>:attribute</b></u> ต้องน้อยกว่า <u><b>:value</b></u> ตัวอักษร.',
        'array' => '<u><b>:attribute</b></u> ต้องมีน้อยกว่า <u><b>:value</b></u> รายการ.',
    ],
    'lte' => [
        'numeric' => '<u><b>:attribute</b></u> ต้องน้อยกว่าหรือเท่ากับ <u><b>:value</b></u>.',
        'file' => '<u><b>:attribute</b></u> ต้องน้อยกว่าหรือเท่ากับ <u><b>:value</b></u> กิโลไบต์.',
        'string' => '<u><b>:attribute</b></u> ต้องน้อยกว่าหรือเท่ากับ <u><b>:value</b></u> ตัวอักษร.',
        'array' => '<u><b>:attribute</b></u> ต้องไม่มีมากกว่า <u><b>:value</b></u> รายการ.',
    ],
    'mac_address' => '<u><b>:attribute</b></u> ต้องเป็น MAC address ที่ถูกต้อง.',
    'max' => [
        'numeric' => '<u><b>:attribute</b></u> ต้องไม่มากกว่า <u><b>:max</b></u>.',
        'file' => '<u><b>:attribute</b></u> ต้องไม่มากกว่า <u><b>:max</b></u> กิโลไบต์.',
        'string' => '<u><b>:attribute</b></u> ต้องไม่มากกว่า <u><b>:max</b></u> ตัวอักษร.',
        'array' => '<u><b>:attribute</b></u> ต้องไม่มีมากกว่า <u><b>:max</b></u> รายการ.',
    ],
    'mimes' => '<u><b>:attribute</b></u> ต้องเป็นไฟล์ประเภท: <u><b>:value</b></u>s.',
    'mimetypes' => '<u><b>:attribute</b></u> ต้องเป็นไฟล์ประเภท: <u><b>:value</b></u>s.',
    'min' => [
        'numeric' => '<u><b>:attribute</b></u> ต้องมีค่าอย่างน้อย <u><b>:min</b></u>.',
        'file' => '<u><b>:attribute</b></u> ต้องมีขนาดอย่างน้อย <u><b>:min</b></u> กิโลไบต์.',
        'string' => '<u><b>:attribute</b></u> ต้องมีความยาวอย่างน้อย <u><b>:min</b></u> ตัวอักษร.',
        'array' => '<u><b>:attribute</b></u> ต้องมีอย่างน้อย <u><b>:min</b></u> รายการ.',
    ],
    'multiple_of' => '<u><b>:attribute</b></u> ต้องเป็นจำนวนเต็มที่หารด้วย <u><b>:value</b></u> ลงตัว.',
    'not_in' => 'ค่าที่เลือกสำหรับ <u><b>:attribute</b></u> ไม่ถูกต้อง.',
    'not_regex' => 'รูปแบบ <u><b>:attribute</b></u> ไม่ถูกต้อง.',
    'numeric' => '<u><b>:attribute</b></u> ต้องเป็นตัวเลข.',
    'password' => 'รหัสผ่านไม่ถูกต้อง.',
    'present' => 'ฟิลด์ <u><b>:attribute</b></u> ต้องมีข้อมูล.',
    'prohibited' => 'ฟิลด์ <u><b>:attribute</b></u> ถูกห้ามใช้งาน.',
    'prohibited_if' => 'ฟิลด์ <u><b>:attribute</b></u> ถูกห้ามใช้งานเมื่อ <u><b>:other</b></u> มีค่าเป็น <u><b>:value</b></u>.',
    'prohibited_unless' => 'ฟิลด์ <u><b>:attribute</b></u> ถูกห้ามใช้งานเว้นแต่ <u><b>:other</b></u> จะอยู่ในค่าต่อไปนี้: <u><b>:value</b></u>s.',
    'prohibits' => 'ฟิลด์ <u><b>:attribute</b></u> ป้องกันไม่ให้ <u><b>:other</b></u> มีค่า.',
    'regex' => 'รูปแบบ <u><b>:attribute</b></u> ไม่ถูกต้อง.',
    'required' => '<u><b>:attribute</b></u> ต้องระบุข้อมูล',
    'required_array_keys' => 'ฟิลด์ <u><b>:attribute</b></u> ต้องมีรายการสำหรับ: <u><b>:value</b></u>s.',
    'required_if' => 'ฟิลด์ <u><b>:attribute</b></u> จำเป็นต้องระบุเมื่อ <u><b>:other</b></u> มีค่าเป็น <u><b>:value</b></u>.',
    'required_unless' => 'ฟิลด์ <u><b>:attribute</b></u> จำเป็นต้องระบุเว้นแต่ <u><b>:other</b></u> จะอยู่ในค่าต่อไปนี้: <u><b>:value</b></u>s.',
    'required_with' => 'ฟิลด์ <u><b>:attribute</b></u> จำเป็นต้องระบุเมื่อ <u><b>:value</b></u>s มีการระบุ.',
    'required_with_all' => 'ฟิลด์ <u><b>:attribute</b></u> จำเป็นต้องระบุเมื่อ <u><b>:value</b></u>s มีการระบุ.',
    'required_without' => 'ฟิลด์ <u><b>:attribute</b></u> จำเป็นต้องระบุเมื่อ <u><b>:value</b></u>s ไม่มีการระบุ.',
    'required_without_all' => 'ฟิลด์ <u><b>:attribute</b></u> จำเป็นต้องระบุเมื่อไม่มีการระบุค่าใน <u><b>:value</b></u>s.',
    'same' => '<u><b>:attribute</b></u> และ <u><b>:other</b></u> ต้องตรงกัน.',
    'size' => [
        'numeric' => '<u><b>:attribute</b></u> ต้องมีขนาด <u><b>:size</b></u>.',
        'file' => '<u><b>:attribute</b></u> ต้องมีขนาด <u><b>:size</b></u> กิโลไบต์.',
        'string' => '<u><b>:attribute</b></u> ต้องมีความยาว <u><b>:size</b></u> ตัวอักษร.',
        'array' => '<u><b>:attribute</b></u> ต้องมี <u><b>:size</b></u> รายการ.',
    ],
    'starts_with' => '<u><b>:attribute</b></u> ต้องเริ่มต้นด้วยค่าใดค่าหนึ่งต่อไปนี้: <u><b>:value</b></u>s.',
    'string' => '<u><b>:attribute</b></u> ต้องเป็นข้อความ.',
    'timezone' => '<u><b>:attribute</b></u> ต้องเป็นโซนเวลาที่ถูกต้อง.',
    'unique' => '<u><b>:attribute</b></u> มีการใช้งานอยู่แล้ว',
    'uploaded' => '<u><b>:attribute</b></u> ไม่สามารถอัปโหลดได้.',
    'url' => '<u><b>:attribute</b></u> ต้องเป็น URL ที่ถูกต้อง.',
    'uuid' => '<u><b>:attribute</b></u> ต้องเป็น UUID ที่ถูกต้อง.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'password'=> 'รหัสผ่าน',
        'confirm_password'=> 'ยืนยันรหัสผ่าน',
        'start_date' => 'วันที่เริ่มต้น',
        'end_date' => 'วันที่สิ้นสุด',
        'description' => 'คำอธิบาย',
    ],

];
