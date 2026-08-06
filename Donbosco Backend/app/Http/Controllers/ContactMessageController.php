<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageFormRequest;
use App\Services\ContactMessageService;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    protected $contactMessageService;
    public function __construct(ContactMessageService $contactMessageService)
    {
        $this->contactMessageService = $contactMessageService;
    }
public function send_message(ContactMessageFormRequest $request)
    {
        $this->contactMessageService->send_message($request->validated());
        return response()->json(['message' => __('messages.message_sent')], 200);
    }
}
