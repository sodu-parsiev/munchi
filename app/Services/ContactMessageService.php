<?php

namespace App\Services;

use App\Models\ContactMessage;

class ContactMessageService
{
    public function create(array $data): ContactMessage
    {
        $contactMessage = new ContactMessage();
        $contactMessage->name = $data['name'];
        $contactMessage->email = $data['email'];
        $contactMessage->message = $data['message'];
        $contactMessage->save();

        return $contactMessage;
    }
}
