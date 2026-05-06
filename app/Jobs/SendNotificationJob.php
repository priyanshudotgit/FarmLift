<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string $userId,
        private readonly string $message,
        private readonly string $type = 'general',
        private readonly array  $data = []
    ) {}

    public function handle(): void
    {
        Notification::create([
            'user_id' => $this->userId,
            'message' => $this->message,
            'type'    => $this->type,
            'read'    => false,
            'data'    => $this->data,
        ]);
    }
}
