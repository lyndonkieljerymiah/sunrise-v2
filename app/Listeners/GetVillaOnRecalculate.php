<?php

namespace App\Listeners;

use App\Events\Contract\OnRecalculate;
use App\Villa;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GetVillaOnRecalculate
{

    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  OnRecalculate  $event
     * @return void
     */
    public function handle(OnRecalculate $event)
    {
        $villaId = $event->bundle->get("villaId");
        if($villaId != null) {
            $villa = Villa::find($villaId);
            $event->bundle->addOutput('villa',$villa);
        }
    }
}
