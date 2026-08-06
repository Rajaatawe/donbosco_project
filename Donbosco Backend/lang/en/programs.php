<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    */

    'navigation' => 'Programs',
    'plural' => 'Programs',
    'single' => 'Program',

    'title' => 'Programs',
    'create' => 'Add Program',
    'edit' => 'Edit Program',

    /*
    |--------------------------------------------------------------------------
    | Fields
    |--------------------------------------------------------------------------
    */

    'fields' => [
          'created_at' => 'created_at',
        'updated_at' => 'updated_at',
    'title' => 'Program name',
        // Main
        'title_en' => 'Title (English)',
        'title_ar' => 'Title (Arabic)',

        'slug' => 'Slug',
        'slug_helper' => 'Automatically generated from English title',

        'description_en' => 'Description (English)',
        'description_ar' => 'Description (Arabic)',

        // Media
        'cover_image' => 'Cover Image',

        // Dates
        'start_date' => 'Start Date',

        // Status
        'registration_status' => 'Registration Status',
        'status' => 'Status',

        'record_status' => 'Record Status',
    ],

    /*
    |--------------------------------------------------------------------------
    | Status Values
    |--------------------------------------------------------------------------
    */
//
    //
'status_values' => [
        'active' => 'Active',
    'hidden' => 'Hidden',
],

'registration_status_values' => [
        'upcoming' => 'Upcoming',
        'opened' => 'Open',
        'closed' => 'Closed',
    'finished' => 'Finished',
],
    //


//


    'record_status_values' => [
        'active' => 'Active',
        'deleted' => 'Deleted',
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Helpers
    |--------------------------------------------------------------------------
    */

    'placeholders' => [
        'select' => 'Select',
    ],
];
