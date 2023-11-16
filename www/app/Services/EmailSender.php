<?php
namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailSender implements MessageSender
{
    public function send($recipient, $message)
    {
        Mail::raw($message, function ($email) use ($recipient) {
            $email->to($recipient);
        });
    }
}