<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CrudActionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string     $action,
        public string     $modelName,
        public int|string $modelId,
        public int        $userId,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("notifications.{$this->userId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'crud.notification';
    }

    public function broadcastWith(): array
    {
        $labels = [
            'created' => 'criada',
            'updated' => 'atualizada',
            'deleted' => 'excluída',
        ];

        return [
            'message'  => "Tarefa #{$this->modelId} foi {$labels[$this->action]}!",
            'action'   => $this->action,
            'model'    => $this->modelName,
            'model_id' => $this->modelId,
        ];
    }
}