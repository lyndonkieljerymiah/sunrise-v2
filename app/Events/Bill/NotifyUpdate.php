<?php

namespace App\Events\Bill;

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

    protected $arguments;

    public function __construct($arguments = array())
    {
        $this->arguments = $arguments;
    }

    public function getArgument($name) {

        return $this->arguments[$name];
    }


}
