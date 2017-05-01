<?php

namespace App\Events\Contract;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OnCreating
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    
    protected $models = array();

    protected $expectedOutput;
    
    public function __construct($models = array(), &$expectedOutput = array())
    {
        $this->models = $models;

        $this->expectedOutput = &$expectedOutput;
    }

    public function getArguments($name) {

        return $this->models[$name];
    }

    public function setOutput($name,$value) {
        $this->expectedOutput[$name] = $value;
    }
    
}
