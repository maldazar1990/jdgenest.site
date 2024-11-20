<?php

namespace App\Observers;

use App\Users;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(Users $user)
    {
        // Let's say you use config

        if (config('app.email_verification') == false) {
            $user->email_verified_at = now();
            $user->save();
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(Users $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Users $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(Users $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(Users $user): void
    {
        //
    }
}
