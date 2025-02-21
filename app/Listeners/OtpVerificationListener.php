<?php

namespace App\Listeners;

use App\Events\OtpVerificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OtpVerificationListener implements ShouldQueue
{
    use InteractsWithQueue;
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
     * @param  \App\Events\OtpVerificationEvent  $event
     * @return void
     */
    public function handle(OtpVerificationEvent $event)
    {
        $user = $event->user;
        $otp = $event->otp;

        // Save the OTP to the user in the database
        $user->otp = $otp;
        $user->expires_at = now();
        $user->save();
 
    }
}
