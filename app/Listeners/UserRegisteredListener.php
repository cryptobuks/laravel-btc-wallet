<?php

namespace App\Listeners;

use App\Repositories\WalletRepository;
use Artisan;
use \Illuminate\Auth\Events\Registered;

class UserRegisteredListener
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        Artisan::call('wallet:generate', [
           'user'  => $event -> user -> id
        ]);
    }
}
