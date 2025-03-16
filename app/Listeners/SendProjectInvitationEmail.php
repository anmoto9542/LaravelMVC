<?php

namespace App\Listeners;

use App\Events\MemberJoinedProject;
use App\Mail\projectMemberMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendProjectInvitationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MemberJoinedProject $event): void
    {
        // 發送郵件給用戶
        Mail::to($event->user->email)->send(new projectMemberMail($event->user));
        Log::info("已發送郵件給專案成員: {$event->user->email}");
    }
}
