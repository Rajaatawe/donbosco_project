<?php

return [

    'navigation' => 'رسائل التواصل',
    'plural' => 'رسائل التواصل',
    'single' => 'رسالة تواصل',

    'tabs' => [
        'overview' => 'نظرة عامة على الرسالة',
        'management' => 'لوحة الإدارة',
    ],

    'sections' => [
        'sender_snapshot' => 'معلومات المرسل',
        'message' => 'الرسالة',
        'status_control' => 'التحكم بالحالة',
        'internal_notes' => 'الملاحظات الداخلية',
    ],

    'fields' => [
        'id' => 'المعرف',
        'name' => 'الاسم',
        'full_name' => 'الاسم الكامل',
        'email' => 'البريد الإلكتروني',
        'phone' => 'رقم الهاتف',
        'subject' => 'الموضوع',
        'message_content' => 'محتوى الرسالة',
        'status' => 'الحالة',
        'message_status' => 'حالة الرسالة',
        'internal_notes' => 'ملاحظات داخلية',
        'final_notes' => 'الملاحظات النهائية',
        'replied_at' => 'تاريخ الرد',
        'deleted_at' => 'تاريخ الحذف',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التعديل',
    ],

    'statuses' => [
        'new' => 'جديدة',
        'in_progress' => 'قيد المعالجة',
        'replied' => 'تم الرد',
        'archived' => 'مؤرشفة',
    ],

    'helpers' => [
        'archived_notes' => 'لا يمكن تعديل الملاحظات أثناء الأرشفة. قم بتغيير الحالة للتعديل.',
    ],

    'validation' => [
        'archive_notes' => 'يرجى إضافة ملاحظات داخلية قبل أرشفة الرسالة.',
    ],

    'placeholders' => [
        'not_provided' => 'غير متوفر',
    ],

];
