<?php

namespace App\Listeners;

use \App\Events\Contract\OnCreating;
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
        $models = $event->getArguments('tenant');

        $validator = Validator::make($model,[
            'type'          =>  'required',
            'full_name'     =>  'required',
            'email_address' =>  'required|email',
            'instance_address.address_1'    =>  'required',
            'city'  =>  'required',
            'postal_code'   =>  'required'
        ]);

        $validator->after(function($validator) {

        });

        $tenant = $this->repository->attach($models)->instance();

        $event->setOutput("tenant",$tenant);
        
    }
}
