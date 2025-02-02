<?php

namespace App\Http\Controllers\API;

use App\Jobs\HandleGitHubWebhookJob;
use Illuminate\Bus\Dispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class AcceptGitHubWebhooksController
{
    public function __construct(private Dispatcher $bus)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        defer(
            callback: fn() => $this->bus->dispatch(
                command: new HandleGitHubWebhookJob(
                    payload: $request->all(),
                ),
            ),
        );

        HandleGitHubWebhookJob::dispatchSync($request->all());

        return new JsonResponse(
            data: ['message' => 'Webhook accepted.'],
            status: Response::HTTP_ACCEPTED,
        );
    }
}
