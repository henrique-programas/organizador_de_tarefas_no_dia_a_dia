<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CrudNotification extends Notification
{
    use Queueable;

    public string $action;
    public string $modelName;
    public int|string $modelId;

    public function __construct(string $action, string $modelName, int|string $modelId)
    {
        $this->action    = $action;    // 'created' | 'updated' | 'deleted'
        $this->modelName = $modelName;
        $this->modelId   = $modelId;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];   // remova 'mail' se não quiser e-mail
    }

    // ── Banco de dados ──────────────────────────────────────────────
    public function toDatabase(object $notifiable): array
    {
        return [
            'action'     => $this->action,
            'model'      => $this->modelName,
            'model_id'   => $this->modelId,
            'message'    => $this->buildMessage(),
        ];
    }

    // ── E-mail ──────────────────────────────────────────────────────
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Registro {$this->modelName} — {$this->action}")
            ->line($this->buildMessage())
            ->line('Obrigado por usar nossa aplicação!');
    }

    private function buildMessage(): string
    {
        $labels = [
            'created' => 'criado',
            'updated' => 'atualizado',
            'deleted' => 'excluído',
        ];

        $label = $labels[$this->action] ?? $this->action;
        return "O registro #{$this->modelId} de {$this->modelName} foi {$label} com sucesso.";
    }
}