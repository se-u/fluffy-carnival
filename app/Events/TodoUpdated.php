<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TodoUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $todo;

    public function __construct($todo)
    {
        $this->todo = $todo;
    }

    public function broadcastOn()
    {
        return new Channel('todos');
    }

    public function broadcastAs()
    {
        return 'todo.updated';
    }
}
