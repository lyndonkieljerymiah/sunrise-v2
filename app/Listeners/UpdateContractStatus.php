<?php

namespace App\Listeners;

use App\Contract;
use App\Events\Bill\NotifyUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateContractStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotifyUpdate  $event
     * @return void
     */
    public function handle(NotifyUpdate $event)
    {
        $contractId = $event->bundle->get('contract');
        if($contractId != null) {
            $contractModel = Contract::find($contractId);
            $contractModel->active()->save();
        }
    }
}
