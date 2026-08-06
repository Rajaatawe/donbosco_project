<?php

return [

    'navigation' => 'Users',

    'plural' => 'Users',

    'single' => 'User',

    'fields' => [

        'name' => 'Name',

        'email' => 'Email',

        'password' => 'Password',

        'role' => 'Role',

        'status' => 'Status',

        'email_verified_at' => 'Email Verified At',

        'created_at' => 'Created At',

        'updated_at' => 'Updated At',

    ],

    'statuses' => [

        'active' => 'Active',

        'inactive' => 'Inactive',
        'banned' => 'Banned'

    ],

    'actions' => [

        'edit' => 'Edit',

        'delete' => 'Delete',
            'ban' => 'Ban',
        'unban' => 'Unban',

    ],

];
