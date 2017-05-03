<?php

namespace App\Listeners;

use \App\Events\Contract\OnInitialize;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InitializeTenant
{
    
    private $repository; 
    public function __construct(\App\Repositories\TenantRepository $repository)
    {
        $this->repository = $repository;
    }

   
    public function handle(OnInitialize $event)
    {
        $tenant = $this->repository->createInstance();
        
        $event->dispatch('tenant', $tenant);
    }
}
