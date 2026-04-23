<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestHello implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $timestamp;

    public function __construct()
    {
        $this->message = 'Hello from server!';
        $this->timestamp = now()->toDateTimeString();
    }

    public function broadcastOn()
    {
        return new Channel('test-hello');
    }
}
