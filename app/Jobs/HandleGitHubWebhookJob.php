<?php

namespace App\Jobs;

use App\Services\GitHubService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

final class HandleGitHubWebhookJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public array $payload) {}

    public function handle(GitHubService $service): void
    {
        $action = $this->payload['action'];

        match ($action) {
            'published' => $service->release(
                payload: $this->payload,
            ),
            'opened' => $service->opened(
                payload: $this->payload,
            ),
            default => Log::info(
                message: "Unhandled webhook action: $action",
                context: $this->payload,
            ),
        };
    }
}
