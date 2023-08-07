<?php

namespace App\Http\Controllers;

use App\Jobs\SendTransaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function createTransaction(Request $request) {

        try {
            $transaction =[
                "transaction_id"=>$request->id,
                "status"=>"pending"
              ];
          
              // check if transaction existe in database to process requests only once.
              // if exist, we return transaction data
              $find_transaction = Transaction::where("transaction_id", $transaction["transaction_id"])->first();
          
              if($find_transaction){
                   return response()->json(["status"=>$find_transaction->status, "id"=>$find_transaction->transaction_id]);
              }

               // create new transaction
                $new_transaction = Transaction::create($transaction);


                //Background execution of the third-party call using a laravel class job
                // this job executes one second after its creation.
                SendTransaction::dispatch($new_transaction)
                ->delay(now()->addSeconds(1));

                return response()->json(["status"=>$new_transaction->status, "id"=>$new_transaction->transaction_id]);
                

        } catch (\Throwable $th) {
            $message= $th->getMessage();
            return response()->json(["error_messaged"=>$message]);
        }
    }


    public function TransactionWebHook(Request $request) {
        try {
            $transaction_status =$request->status;
            $transaction_id =$request->id;
      
      
            if($request->status == "completed"){
               $transaction_status ="accepted";
            }
      
            // update transaction status
            $find_transaction = Transaction::where("transaction_id", $transaction_id)->first();
      
            $find_transaction->status = $transaction_status;
            $find_transaction->save();
      
            if($transaction_status != "pending") {
               Http::put(env("MOBILE_APP_URL")."/transaction", [
                  'id' => $request->id,
                  'status' => $transaction_status
              ]);
            }
          
         } catch (\Throwable $th) {
          $message= $th->getMessage();
          return response()->json(["error_messaged"=>$message]);
         }
    }
}
