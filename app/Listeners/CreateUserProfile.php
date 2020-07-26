<?php

namespace App\Listeners;

use App\Events\NewUserRegisteredEvent;
use App\UserProfile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserProfile implements ShouldQueue
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
     * @param NewUserRegisteredEvent $event
     * @return void
     */
    public function handle(NewUserRegisteredEvent $event)
    {
        $profile = new UserProfile();
        $profile->name = $event->user->name;
        $profile->bio = 'Developer';
        $profile->save();
    }
}
