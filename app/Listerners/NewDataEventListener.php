<?php

namespace App\Listerners;

use App\Events\NewDataEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewDataEventListener
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
     * @param  NewDataEvent  $event
     * @return void
     */
    public function handle(NewDataEvent $event)
    {
        //
    }
}
