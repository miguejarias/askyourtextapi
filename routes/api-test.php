<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:ai-requests'])
    ->post('/ask', [App\Http\Controllers\AiController::class, 'ask']);
