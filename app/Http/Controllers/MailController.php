<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use App\Mail\DemoMail;

class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'Mail From ENZ',
        ];

        // Get the most recent user (prioritizing last updated)
        $user = User::orderBy('updated_at', 'desc')
                   ->orderBy('created_at', 'desc')
                   ->first();

        if ($user) {
            Mail::to($user->email)->send(new DemoMail($mailData));
            return response()->json([
                'message' => 'Email sent successfully',
                'recipient' => $user->email,
                'type' => $user->updated_at > $user->created_at ? 'Last Updated' : 'Last Added'
            ]);
        }

        return response()->json([
            'message' => 'No users found in database',
            'recipient' => null
        ], 400);
    }
}