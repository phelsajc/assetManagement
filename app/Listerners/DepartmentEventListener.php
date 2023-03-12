<?php

namespace App\Listerners;

use App\Events\DepartmentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DepartmentEventListener
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
     * @param  DepartmentEvent  $event
     * @return void
     */
    public function handle(DepartmentEvent $event)
    {
        //
    }
}
