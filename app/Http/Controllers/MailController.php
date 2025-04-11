<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;

class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'Mail From Erick',
            'body' => 'Testing Email',
        ];

        Mail::to('erick.a.deguzman@isu.edu.ph')->send(new DemoMail($mailData));

        dd('Email is sent successfully.');
    }
}
