<?php

namespace App\Listeners;

use \App\Events\Contract\OnCreating;
use App\Tenant;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\Validator;

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
        $entity = $event->getArguments('tenant');

        $tenantModel = new Tenant();

        $tenant = $tenantModel->saveTenant($entity);

        $event->setOutput("tenant",$tenant);
        
    }
}
