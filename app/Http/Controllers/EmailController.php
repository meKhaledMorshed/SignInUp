<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //store emails data in array

    private array $email = [];
    private ?string $template = null;

    function __construct()
    {
        $this->email['sender']      = config('mail.mailers.smtp.username') . '@mailtrap.io';
        $this->email['senderName']  = config('app.name');
    }

    private function sendemail()
    {
        try {
            // dd($this->email['sender']);
            Mail::send($this->template, $this->email, function ($message) {
                $message->to($this->email['receiver'], $this->email['receiverName'])->subject($this->email['subject']);
                $message->from($this->email['sender'], $this->email['senderName']);
            });

            return true;

            //end
        } catch (Exception $e) {

            return false;
        }
    }

    public function send_token(string $token, string $receiver_email, string $receiver_name = null, string $subject = 'Authentication token')
    {
        try {
            $this->email['token'] = $token;
            $this->email['receiver'] = $receiver_email;
            $this->email['receiverName'] = $receiver_name;
            $this->email['subject'] = $subject;
            $this->template = 'emails.token';

            $send = $this->sendemail();
            $send ?: throw new Exception('send token failed.');

            return true;

            //end
        } catch (Exception $e) {

            return false;
        }
    }
}
