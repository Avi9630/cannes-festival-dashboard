<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtp extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($data)
    {
        $this->data = $data;
        // dd($this->data);
    }

    public function build()
    {
        return $this->view('emails.sendOtp')
            ->to($this->data['to'])
            ->subject($this->data['subject'])
            ->with('data', $this->data['data']);
    }
}
