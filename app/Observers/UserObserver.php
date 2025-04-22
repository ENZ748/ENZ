<?php

namespace App\Observers;

use App\Models\User;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->sendUserNotification($user, 'created');
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Only send if actual changes were made (not just timestamp updates)
        if ($user->wasChanged()) {
            $this->sendUserNotification($user, 'updated');
        }
    }

    /**
     * Send email notification for user activity
     */
    private function sendUserNotification(User $user, string $action): void
    {
        $mailData = [
            'title' => "Account {$action} notification",
            'body' => "Your account was {$action} successfully.",
            'user' => $user,
            'action' => $action,
            'timestamp' => now()->toDateTimeString(),
        ];

        try {
            Mail::to($user->email)
                ->send(new DemoMail($mailData));
            
            \Log::info("Sent {$action} notification to {$user->email}");
        } catch (\Exception $e) {
            \Log::error("Failed to send {$action} notification to {$user->email}: " . $e->getMessage());
        }
    }
}