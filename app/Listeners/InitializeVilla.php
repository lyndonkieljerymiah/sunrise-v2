<?php

namespace App\Listeners;

use \App\Events\Contract\OnInitialize;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InitializeVilla
{
    
    private $repository;

    public function __construct(\App\Repositories\VillaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  OnContractInitialize  $event
     * @return void
     */
    public function handle(OnInitialize $event)
    {
        //trigger create event
        $villas = $this->repository->withChildren()->withStatus('vacant')->get();
        
        foreach($villas as $villa) {
            foreach($villa->villaGalleries as $gallery) {
                $gallery->image_name = asset('img/villa').'/'.$gallery->image_name; 
            }
        }
        
        $event->dispatch('villa', $villas);
    }
}
