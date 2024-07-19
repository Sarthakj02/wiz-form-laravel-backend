<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/open-web', function () {
    Log::info('Request Data', [request()->all()]);
    return "hello";
});

Route::get('/get-hook', function () {
    Log::info('Web hook Data', [request()->all()]);
    // dd(request()->all());
    return "hook response paid ...";
});

Route::post('/v1/webhooks/payment-events', function (Request $request) {
    // Log the request for debugging
    Log::info('Razorpay Webhook Received FAIL', $request->all());
    // dd($request->all());
    // Process the webhook payload
    // ...

    return response()->json(['status' => 'fail']);
});