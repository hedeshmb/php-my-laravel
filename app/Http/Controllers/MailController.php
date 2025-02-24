<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        try {
            var_export(Mail::to(['hedeshmb@gmail.com', 'asher.roth.ar@gmail.com','m.bardehgar.hedeshi@gmail.com'])->send(new TestEmail()));
            exit;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
