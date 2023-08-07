<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class SendTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $transaction;
    /**
     * Create a new job instance.
     */
    public function __construct(Transaction $transaction)
    {
        //
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
           // in this job, we perform an http post request to the third party with the transaction id and the callback return
            Http::post(env("THIRDPARTY_APP_URL")."/transaction", [
                'id' => $this->transaction->transaction_id,
                'webhookUrl' => route("webhokk.url")
            ]);

            Log::info("Transaction send !");
    
        } catch (\Throwable $th) {
            $message= $th->getMessage();
            Log::error("error when call tiers: ".$message);
        }
    }
}
