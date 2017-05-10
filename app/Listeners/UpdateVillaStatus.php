<?php

namespace App\Listeners;

use \App\Events\Contract\NotifyUpdate;
use App\Villa;


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
        $args = $event->bundle->get('villa');

        if($args !== null) {
            //make villa occupied
            $villaModel = Villa::find($args["id"]);
            if($args["status"] == 'occupied')
                $villaModel->setToOccupied();
            else
                $villaModel->setToVacant();
            $villaModel->save();
        }
    }
}
