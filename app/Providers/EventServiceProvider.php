<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Contract\NotifyUpdate' => [
            'App\Listeners\UpdateVillaStatus',
            'App\Listeners\RemoveTenant'
        ],
        'App\Events\Contract\OnCreating' => [
            'App\Listeners\CreateTenant',
            'App\Listeners\GetVilla'
        ],
        'App\Events\Contract\OnRecalculate' => [
            'App\Listeners\GetVillaOnRecalculate'
        ],
        'App\Events\Bill\NotifyUpdate' => [
            'App\Listeners\UpdateContractStatus'
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
