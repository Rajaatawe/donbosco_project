<?php

namespace App\Services;

use App\Repositories\ContactMessageRepository;
use Illuminate\Support\Facades\Auth;

class ContactMessageService
{
    protected $contactMessageRepository;
    public function __construct(ContactMessageRepository $contactMessageRepository)
    {
        $this->contactMessageRepository = $contactMessageRepository;
    }
    public function send_message(array $data)
    {
        $data['user_id'] = Auth::id();
        return $this->contactMessageRepository->send_message($data);
    }
}
