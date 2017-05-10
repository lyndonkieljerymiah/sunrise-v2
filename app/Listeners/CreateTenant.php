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


    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  OnContractCreate  $event
     * @return void
     */
    public function handle(OnCreating $event)
    {
        $entity = $event->bundle->get('tenant');
        if($entity != null) {
            $tenantModel = new Tenant();
            $entity['code'] = $entity['reg_id'];
            $tenant = $tenantModel->saveTenant($entity);
            $event->bundle->addOutput("tenant",$tenant);
        }
    }
}
