<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class SendTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $transaction;
    /**
     * Create a new job instance.
     */
    public function __construct($transaction)
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
            $user = [
                    "name"=>"mkdir",
                "email"=>"reseaux1999+".$this->transaction["id"]."@gmail.com",
                "password"=>Hash::make("password")
            ];
    
    
            User::create($user);
            print("user craeted");
    
            // return response()->json(["status"=>true, "message"=>"Users creates succesfully"]);
        } catch (\Throwable $th) {
            $message= $th->getMessage();
            print("eeror: ".$message);
        }
    }
}
