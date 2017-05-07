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
        $villaId = $event->getArguments('villaId');

        $villa = Villa::find($villaId);

        $event->setOutput('villa',$villa);

    }
}
