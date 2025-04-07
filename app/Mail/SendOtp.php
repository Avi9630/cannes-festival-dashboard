<?php

namespace App\Mail;

use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class SendOtp extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->view('emails.sendOtp')
            ->to($this->data['to'])
            ->subject($this->data['subject'])
            ->with('data', $this->data['data']);
    }
}
