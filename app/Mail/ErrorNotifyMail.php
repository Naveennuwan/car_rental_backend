<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;

class ErrorNotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dataLayerName;
    public $functionName;
    public $errorMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataLayerName, $functionName, $errorMessage)
    {
        $this->dataLayerName = $dataLayerName;
        $this->functionName = $functionName;
        $this->errorMessage = $errorMessage;
    }
    
    public function sendDataLayerError(){
        Mail::send("emails.error_notify_mail", [
            'dataLayerName' => $this->dataLayerName,
            'functionName' => $this->functionName,
            'errorMessage' => $this->errorMessage
        ], function ($message) {
            $message->to("naveennuwan@gmail.com");
            $message->subject("Data Layer Error");
        });
    }
}
