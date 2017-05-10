<?php

namespace App\Listeners;

use App\Events\Contract\OnCreating;
use App\Villa;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GetVilla
{
    

    public function __construct()
    {

    }

    public function handle(OnCreating $event)
    {
        $villaId = $event->bundle->get('villaId');
        if($villaId != null) {
            $villa = Villa::find($villaId);
            $event->bundle->addOutput('villa',$villa);
        }
    }
}
