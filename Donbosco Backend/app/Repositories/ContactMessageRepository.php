<?php

namespace App\Repositories;

use App\Models\ContactMessage;

class ContactMessageRepository
{
    protected $contactMessageModel;
    public function __construct(ContactMessage $contactMessageModel)
    {
        $this->contactMessageModel = $contactMessageModel;
    }
    public function send_message(array $data)
    {
        return $this->contactMessageModel->create($data);
    }
}
