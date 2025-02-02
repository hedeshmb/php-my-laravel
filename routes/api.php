<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/v1/ingress/github', [\App\Http\Controllers\API\AcceptGitHubWebhooksController::class,'__invoke']);

