<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Log;
use Exception;

class MailController extends Controller
{
    public function index(Request $request)
        {
            try {
                // Get the most recent user (prioritizing last updated)
                $user = User::orderBy('updated_at', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->first();

                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No users found in database',
                        'recipient' => null
                    ], 404);
                }

            $mailData = [
                'title' => 'Mail From ENZ',
                'body' => $this->generateEmailContent($user),
                'user' => $user
            ];

            // Send email
            Mail::to($user->email)->send(new DemoMail($mailData));

            // Log the email sending
            Log::info('Email sent to ' . $user->email, [
                'type' => $user->updated_at > $user->created_at ? 'Last Updated' : 'Last Added',
                'time' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully',
                'recipient' => $user->email,
                'type' => $user->updated_at > $user->created_at ? 'Last Updated' : 'Last Added',
                'user_name' => $user->name
            ]);

        } catch (Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage(),
                'recipient' => $user->email ?? null
            ], 500);
        }
    }

    /**
     * Generate dynamic email content based on user
     */
    protected function generateEmailContent(User $user): string
    {
        if ($user->updated_at > $user->created_at) {
            return "Hello {$user->name}, your account details have been recently updated.";
        }

        return "Welcome {$user->name}! Your account has been successfully created.";
    }
}