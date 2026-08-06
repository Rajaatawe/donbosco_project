<?php

return [

'tabs' => [
    'overview' => 'Message Overview',
    'management' => 'Management Console',
],

'sections' => [
    'sender_snapshot' => 'Sender Snapshot',
    'message' => 'Message',
    'status_control' => 'Status Control',
    'internal_notes' => 'Internal Audit Notes',
],

'fields' => [
    'id' => 'ID',
    'name' => 'Name',
    'full_name' => 'Full Name',
    'email' => 'Email',
    'phone' => 'Phone',
    'subject' => 'Subject',
    'message_content' => 'Message Content',
    'status' => 'Status',
    'message_status' => 'Message Status',
    'internal_notes' => 'Internal Notes',
    'final_notes' => 'Final Internal Notes',
    'replied_at' => 'Replied At',
    'deleted_at' => 'Deleted At',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
],

'statuses' => [
    'new' => 'New',
    'in_progress' => 'In Progress',
    'replied' => 'Replied',
    'archived' => 'Archived',
],

'helpers' => [
    'archived_notes' => 'Notes cannot be edited while archived. Change status to update.',
],

'validation' => [
    'archive_notes' => 'Please provide internal notes before archiving the message.',
],

'placeholders' => [
    'not_provided' => 'Not provided',
],
    /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    */

    'navigation' => 'Contact Messages',
    'plural' => 'Contact Messages',
    'single' => 'Contact Message',

    /*
    |--------------------------------------------------------------------------
    | Fields
    |--------------------------------------------------------------------------
    */

  

];
