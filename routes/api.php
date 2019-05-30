<?php
use App\Http\Controllers;

// Routes
$app->get('/', Controllers\TestController::class, 'index');