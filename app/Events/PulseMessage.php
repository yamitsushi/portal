<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Storage;
use App\Models\CoinLog;

class PulseMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pulse, $time, $mac, $timeout;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $time = 0;
        $log = CoinLog::with('client:id,mac')->find($id);
        $rate = collect(json_decode(Storage::get('rates.json'), true))->sortBy('pulse')->reverse()->toArray();

        if($log->pulse > 0) {
            $pulse = $log->pulse;
            foreach($rate as $temp) {
                if((integer) ($pulse / $temp['pulse']) > 0) {
                    $time += $temp['time'] * (integer) ($pulse / $temp['pulse']);
                    $pulse = $pulse % $temp['pulse'];
                };
            };

        };

        $this->timeout = 60;
        $this->pulse = $log->pulse;
        $this->time = $time;
        $this->mac = $log->client->mac;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('InsertCoin');
    }
}
