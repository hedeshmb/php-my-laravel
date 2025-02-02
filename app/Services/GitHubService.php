<?php

namespace App\Services;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Log;

final class GitHubService
{
    public function __construct(private DatabaseManager $database) {}

    public function release(array $payload): void
    {
        Log::error("release release");

        $this->database->transaction(function () use ($payload) {
           Log::error("release release");
        });
    }

    public function opened(array $payload): void
    {
        Log::error("release release");

        $this->database->transaction(function () use ($payload) {
            Log::error("opened");
        });
    }
}
