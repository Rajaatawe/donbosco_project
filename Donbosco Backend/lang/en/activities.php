<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    */

    'navigation' => 'Activities',
    'plural' => 'Activities',
    'single' => 'Activity',

    'title' => 'Activities',
    'create' => 'Add Activity',
    'edit' => 'Edit Activity',

    /*
    |--------------------------------------------------------------------------
    | Fields
    |--------------------------------------------------------------------------
    */

    'fields' => [

        // Category
        'category' => 'Category',

        // Title
        'title_en' => 'Title (English)',
        'title_ar' => 'Title (Arabic)',

        // Slug
        'slug' => 'Slug',
        'slug_helper' => 'SEO-friendly URL automatically generated from the English title',

        // Summary
        'summary_en' => 'Summary (English)',
        'summary_ar' => 'Summary (Arabic)',

        // Content
        'content_en' => 'Content (English)',
        'content_ar' => 'Content (Arabic)',

        // Media
        'cover_image' => 'Cover Image',

        // Status
        'status' => 'Status',

        // Featured
        'featured' => 'Featured',
    ],

    /*
    |--------------------------------------------------------------------------
    | Status values
    |--------------------------------------------------------------------------
    */

    'status_values' => [
        'draft' => 'Draft',
        'published' => 'Published',
        'hidden' => 'Hidden',
        'archived' => 'Archived',
    ],

    'fields.title' => 'Activity Name',
    'fields.record_status' => 'Activity Status',
    'fields.created_at' => 'Created at: ',

    /*
    |--------------------------------------------------------------------------
    | UI helpers
    |--------------------------------------------------------------------------
    */

    'placeholders' => [
        'select' => 'Select',
    ],

];
