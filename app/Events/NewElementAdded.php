<?php

namespace App\Events;

use App\Models\Action;
use App\Models\Document;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable; // Use ShouldBroadcastNow
use Illuminate\Queue\SerializesModels;

class NewElementAdded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $document;

    public $action;

    /**
     * Create a new event instance.
     */
    public function __construct(Document $document, Action $action)
    {

        $this->document = $document;
        $this->action = $action;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-notifications.'.$this->document->id),
        ];
    }

    public function broadcastWith(): array
    {
        $data  = [];
        if ($this->document) {
            $data['document'] = $this->document->toArray();
        }
        if ($this->action) {
            $data['action'] = $this->action->toArray();
        }
            
        return $data;
    }
}
