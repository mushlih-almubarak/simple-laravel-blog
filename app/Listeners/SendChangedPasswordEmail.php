<?php

namespace App\Listeners;

use App\Mail\PasswordChangedEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendChangedPasswordEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        $user = $event->user;
        Mail::to($user)
            ->send(new PasswordChangedEmail($user));
    }
}
