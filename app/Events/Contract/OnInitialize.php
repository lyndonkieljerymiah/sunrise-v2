<?php

namespace App\Events\Contract;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OnInitialize
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $outputs;
    
    public function __construct(&$outputs = array())
    {
        $this->outputs = &$outputs;
    }


    public function dispatch($name,$value) {
        
        $this->outputs[$name] = $value;
    }

 
}
