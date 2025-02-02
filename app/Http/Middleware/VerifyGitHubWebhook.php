<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

final class VerifyGitHubWebhook
{
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if (! $this->isValidSource($request->ip())) {
            return new JsonResponse(
                data: ['message' => 'Invalid source IP.'],
                status: 403,
            );
        }

        $signature = $request->header('X-Hub-Signature-256');
        $secret = config('services.github.webhook_secret');

        if ( ! $signature ||  ! $this->isValidSignature(
                $request->getContent(),
                $signature,
                $secret,
            )) {
            return new JsonResponse(
                data: ['message' => 'Invalid signature.'],
                status: 403,
            );
        }

        return $next($request);
    }

    private function isValidSignature(
        string $payload,
        string $signature,
        string $secret,
    ): bool {
        return hash_equals(
            'sha256=' . hash_hmac('sha256', $payload, $secret),
            $signature
        );
    }

    private function isValidSource(string $ip): bool
    {
        $validIps = cache()->remember(
            key: 'github:webhook_ips',
            ttl: 3600,
            callback: fn () => Http::get(
                url: 'https://api.github.com/meta',
            )->json('hooks', []),
        );

        return in_array($ip, $validIps, true);
    }
}
