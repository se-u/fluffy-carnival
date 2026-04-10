<?php

namespace App\Events;

use App\Models\JadwalPeriksa;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntrianUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jadwalId;
    public $noAntrianSekarang;
    public $sisaAntrian;

    public function __construct($jadwalId, $noAntrianSekarang, $sisaAntrian)
    {
        $this->jadwalId = $jadwalId;
        $this->noAntrianSekarang = $noAntrianSekarang;
        $this->sisaAntrian = $sisaAntrian;
    }

    public function broadcastOn()
    {
        return new Channel('antrian.' . $this->jadwalId);
    }

    public function broadcastAs()
    {
        return 'antrian.updated';
    }
}
