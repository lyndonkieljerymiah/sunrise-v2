<?php

namespace App\Events\Bill;

use App\Services\Bundle;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bundle;

    public function __construct(Bundle &$bundle)
    {
        $this->bundle = &$bundle;
    }

}
