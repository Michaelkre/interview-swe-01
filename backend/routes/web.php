<?php

use App\Http\Controllers\API\ProduitController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StripeWebHookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

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


Route::post('/transaction', function (Request $request) {
   try {
    $transaction_id = $request->id;
    return response()->json(["status"=>"pending", "id"=>$transaction_id]);
   } catch (\Throwable $th) {
    $message= $th->getMessage();
    return response()->json(["error_messaged"=>$message]);
   }
});


Route::get('/transaction', function (Request $request) {
   try {
    $transaction_id = $request->id;
    return response()->json(["status"=>"pending", "id"=>$transaction_id]);
   } catch (\Throwable $th) {
    $message= $th->getMessage();
    return response()->json(["error_messaged"=>$message]);
   }
});