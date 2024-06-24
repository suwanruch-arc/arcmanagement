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

    'accepted' => 'ต้องยอมรับ :attribute.',
    'accepted_if' => 'ต้องยอมรับ :attribute เมื่อ :other มีค่าเป็น :value.',
    'active_url' => ':attribute ไม่ใช่ URL ที่ถูกต้อง.',
    'after' => ':attribute ต้องเป็นวันที่หลัง :date.',
    'after_or_equal' => ':attribute ต้องเป็นวันที่หลังหรือเท่ากับ :date.',
    'alpha' => ':attribute ต้องประกอบด้วยตัวอักษรเท่านั้น.',
    'alpha_dash' => ':attribute ต้องประกอบด้วยตัวอักษร ตัวเลข เครื่องหมายขีดกลาง และขีดล่างเท่านั้น.',
    'alpha_num' => ':attribute ต้องประกอบด้วยตัวอักษรและตัวเลขเท่านั้น.',
    'array' => ':attribute ต้องเป็นอาเรย์.',
    'before' => ':attribute ต้องเป็นวันที่ก่อน :date.',
    'before_or_equal' => ':attribute ต้องเป็นวันที่ก่อนหรือเท่ากับ :date.',
    'between' => [
        'numeric' => ':attribute ต้องอยู่ระหว่าง :min และ :max.',
        'file' => ':attribute ต้องมีขนาด :min ถึง :max กิโลไบต์.',
        'string' => ':attribute ต้องมีความยาว :min ถึง :max ตัวอักษร.',
        'array' => ':attribute ต้องมี :min ถึง :max รายการ.',
    ],
    'boolean' => 'ฟิลด์ :attribute ต้องเป็น true หรือ false.',
    'confirmed' => 'การยืนยัน :attribute ไม่ตรงกัน.',
    'current_password' => 'รหัสผ่านไม่ถูกต้อง.',
    'date' => ':attribute ไม่ใช่วันที่ที่ถูกต้อง.',
    'date_equals' => ':attribute ต้องเป็นวันที่เท่ากับ :date.',
    'date_format' => ':attribute ไม่ตรงกับรูปแบบ :format.',
    'declined' => ':attribute ต้องถูกปฏิเสธ.',
    'declined_if' => ':attribute ต้องถูกปฏิเสธเมื่อ :other มีค่าเป็น :value.',
    'different' => ':attribute และ :other ต้องไม่เหมือนกัน.',
    'digits' => ':attribute ต้องเป็น :digits หลัก.',
    'digits_between' => ':attribute ต้องอยู่ระหว่าง :min และ :max หลัก.',
    'dimensions' => ':attribute มีขนาดภาพไม่ถูกต้อง.',
    'distinct' => 'ฟิลด์ :attribute มีค่าซ้ำ.',
    'email' => ':attribute ต้องเป็นที่อยู่อีเมลที่ถูกต้อง.',
    'ends_with' => ':attribute ต้องสิ้นสุดด้วยหนึ่งในค่าต่อไปนี้: :values.',
    'enum' => 'ค่าที่เลือกสำหรับ :attribute ไม่ถูกต้อง.',
    'exists' => 'ค่าที่เลือกสำหรับ :attribute ไม่ถูกต้อง.',
    'file' => ':attribute ต้องเป็นไฟล์.',
    'filled' => 'ฟิลด์ :attribute ต้องมีค่า.',
    'gt' => [
        'numeric' => ':attribute ต้องมากกว่า :value.',
        'file' => ':attribute ต้องมากกว่า :value กิโลไบต์.',
        'string' => ':attribute ต้องมากกว่า :value ตัวอักษร.',
        'array' => ':attribute ต้องมีมากกว่า :value รายการ.',
    ],
    'gte' => [
        'numeric' => ':attribute ต้องมากกว่าหรือเท่ากับ :value.',
        'file' => ':attribute ต้องมากกว่าหรือเท่ากับ :value กิโลไบต์.',
        'string' => ':attribute ต้องมากกว่าหรือเท่ากับ :value ตัวอักษร.',
        'array' => ':attribute ต้องมี :value รายการหรือมากกว่า.',
    ],
    'image' => ':attribute ต้องเป็นภาพ.',
    'in' => 'ค่าที่เลือกสำหรับ :attribute ไม่ถูกต้อง.',
    'in_array' => 'ฟิลด์ :attribute ไม่มีอยู่ใน :other.',
    'integer' => ':attribute ต้องเป็นจำนวนเต็ม.',
    'ip' => ':attribute ต้องเป็น IP address ที่ถูกต้อง.',
    'ipv4' => ':attribute ต้องเป็น IPv4 address ที่ถูกต้อง.',
    'ipv6' => ':attribute ต้องเป็น IPv6 address ที่ถูกต้อง.',
    'json' => ':attribute ต้องเป็น JSON string ที่ถูกต้อง.',
    'lt' => [
        'numeric' => ':attribute ต้องน้อยกว่า :value.',
        'file' => ':attribute ต้องน้อยกว่า :value กิโลไบต์.',
        'string' => ':attribute ต้องน้อยกว่า :value ตัวอักษร.',
        'array' => ':attribute ต้องมีน้อยกว่า :value รายการ.',
    ],
    'lte' => [
        'numeric' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value.',
        'file' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value กิโลไบต์.',
        'string' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value ตัวอักษร.',
        'array' => ':attribute ต้องไม่มีมากกว่า :value รายการ.',
    ],
    'mac_address' => ':attribute ต้องเป็น MAC address ที่ถูกต้อง.',
    'max' => [
        'numeric' => ':attribute ต้องไม่มากกว่า :max.',
        'file' => ':attribute ต้องไม่มากกว่า :max กิโลไบต์.',
        'string' => ':attribute ต้องไม่มากกว่า :max ตัวอักษร.',
        'array' => ':attribute ต้องไม่มีมากกว่า :max รายการ.',
    ],
    'mimes' => ':attribute ต้องเป็นไฟล์ประเภท: :values.',
    'mimetypes' => ':attribute ต้องเป็นไฟล์ประเภท: :values.',
    'min' => [
        'numeric' => ':attribute ต้องมีค่าอย่างน้อย :min.',
        'file' => ':attribute ต้องมีขนาดอย่างน้อย :min กิโลไบต์.',
        'string' => ':attribute ต้องมีความยาวอย่างน้อย :min ตัวอักษร.',
        'array' => ':attribute ต้องมีอย่างน้อย :min รายการ.',
    ],
    'multiple_of' => ':attribute ต้องเป็นจำนวนเต็มที่หารด้วย :value ลงตัว.',
    'not_in' => 'ค่าที่เลือกสำหรับ :attribute ไม่ถูกต้อง.',
    'not_regex' => 'รูปแบบ :attribute ไม่ถูกต้อง.',
    'numeric' => ':attribute ต้องเป็นตัวเลข.',
    'password' => 'รหัสผ่านไม่ถูกต้อง.',
    'present' => 'ฟิลด์ :attribute ต้องมีข้อมูล.',
    'prohibited' => 'ฟิลด์ :attribute ถูกห้ามใช้งาน.',
    'prohibited_if' => 'ฟิลด์ :attribute ถูกห้ามใช้งานเมื่อ :other มีค่าเป็น :value.',
    'prohibited_unless' => 'ฟิลด์ :attribute ถูกห้ามใช้งานเว้นแต่ :other จะอยู่ในค่าต่อไปนี้: :values.',
    'prohibits' => 'ฟิลด์ :attribute ป้องกันไม่ให้ :other มีค่า.',
    'regex' => 'รูปแบบ :attribute ไม่ถูกต้อง.',
    'required' => ':attribute ต้องระบุข้อมูล',
    'required_array_keys' => 'ฟิลด์ :attribute ต้องมีรายการสำหรับ: :values.',
    'required_if' => 'ฟิลด์ :attribute จำเป็นต้องระบุเมื่อ :other มีค่าเป็น :value.',
    'required_unless' => 'ฟิลด์ :attribute จำเป็นต้องระบุเว้นแต่ :other จะอยู่ในค่าต่อไปนี้: :values.',
    'required_with' => 'ฟิลด์ :attribute จำเป็นต้องระบุเมื่อ :values มีการระบุ.',
    'required_with_all' => 'ฟิลด์ :attribute จำเป็นต้องระบุเมื่อ :values มีการระบุ.',
    'required_without' => 'ฟิลด์ :attribute จำเป็นต้องระบุเมื่อ :values ไม่มีการระบุ.',
    'required_without_all' => 'ฟิลด์ :attribute จำเป็นต้องระบุเมื่อไม่มีการระบุค่าใน :values.',
    'same' => ':attribute และ :other ต้องตรงกัน.',
    'size' => [
        'numeric' => ':attribute ต้องมีขนาด :size.',
        'file' => ':attribute ต้องมีขนาด :size กิโลไบต์.',
        'string' => ':attribute ต้องมีความยาว :size ตัวอักษร.',
        'array' => ':attribute ต้องมี :size รายการ.',
    ],
    'starts_with' => ':attribute ต้องเริ่มต้นด้วยค่าใดค่าหนึ่งต่อไปนี้: :values.',
    'string' => ':attribute ต้องเป็นข้อความ.',
    'timezone' => ':attribute ต้องเป็นโซนเวลาที่ถูกต้อง.',
    'unique' => ':attribute มีการใช้งานอยู่แล้ว',
    'uploaded' => ':attribute ไม่สามารถอัปโหลดได้.',
    'url' => ':attribute ต้องเป็น URL ที่ถูกต้อง.',
    'uuid' => ':attribute ต้องเป็น UUID ที่ถูกต้อง.',

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
        'status' => 'สถานะ',
    ],

];
