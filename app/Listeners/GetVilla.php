<?php

namespace App\Listeners;

use App\Events\Contract\OnCreating;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GetVilla
{
    
    private $repository;
    public function __construct(\App\Repositories\VillaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  OnCreating  $event
     * @return void
     */
    public function handle(OnCreating $event)
    {
        $villaId = $event->getArguments('villaId');

        $villa = $this->repository->single($villaId);

        $event->setOutput('villa',$villa->villa_no);

    }
}
