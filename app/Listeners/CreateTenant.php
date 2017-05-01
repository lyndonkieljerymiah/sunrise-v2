<?php

namespace App\Listeners;

use \App\Events\Contract\OnCreating;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $repository;

    public function __construct(\App\Repositories\TenantRepository $repository) 
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  OnContractCreate  $event
     * @return void
     */
    public function handle(OnCreating $event)
    {
        $models = $event->getArguments('tenant');

        $this->repository->attach($models);

        $tenant = $this->repository->lastRecord();

        $event->setOutput("tenant",$tenant->id);
        
    }
}
