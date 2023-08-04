<?php

use App\Jobs\SendTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/users", function(){

    $transaction = Transaction::create(
        [
            "id"=>rand(1, 100),
            "status"=>"success"
        ]

    );

    SendTransaction::dispatch($transaction)
    ->delay(now()->addMinutes(10));


return response()->json(["data"=>User::all(), "jobId"=>""]);
});