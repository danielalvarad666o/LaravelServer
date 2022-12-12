<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class processSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;

  
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
     
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       Http::withBasicAuth('AC83939905e7c70332ed1adf2ce5eba13e', 'f8398f71a0748a5e89ed5d9746412196')
        ->asForm()
        ->post('https://api.twilio.com/2010-04-01/Accounts/AC83939905e7c70332ed1adf2ce5eba13e/Messages.json',[
           
            'To'=>"whatsapp:+521{$this->user->telefono}",
            'From'=>'whatsapp:+14155238886',
            'Body'=>"Tu codigo de verificacion es: {$this->user->codigo}",
        ]);
    }
}
