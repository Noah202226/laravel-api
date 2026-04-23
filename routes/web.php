<?php

use Illuminate\Support\Facades\Route;
use illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/health-check', function () {
    try {
        
        return response()->json(['status' => 'online', "server_time" => now()->toDateTimeString(), "message" => "The server is healthy and connected to the database."]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
});