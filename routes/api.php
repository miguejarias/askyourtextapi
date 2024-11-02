<?php

use App\Http\Controllers\AiController;
use Illuminate\Support\Facades\Route;

Route::post('/ask', [AiController::class, 'ask']);
