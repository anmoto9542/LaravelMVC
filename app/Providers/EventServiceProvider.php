<?php

namespace App\Providers;

use App\Events\MemberJoinedProject;
use App\Listeners\SendProjectInvitationEmail;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        MemberJoinedProject::class => [
            SendProjectInvitationEmail::class,
        ],
    ];
}
