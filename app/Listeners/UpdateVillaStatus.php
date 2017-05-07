<?php

namespace App\Listeners;

use \App\Events\Contract\NotifyUpdate;
use App\Villa;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateVillaStatus
{
    
    protected $repository;
    
    public function __construct(\App\Repositories\VillaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  OnContractCreate  $event
     * @return void
     */
    public function handle(NotifyUpdate $event)
    {
        $args = $event->getArguments('villa');

        //make villa occupied
        $villaModel = Villa::find($args["id"]);
        
        if($args["status"] == 'occupied')
            $villaModel->setToOccupied();
        else 
            $villaModel->setToVacant();

        $villaModel->save();
    }
}
