<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Http\Clients\ExchangeRateUsdClient;
use Carbon\Carbon;

class RegisterExchangeRateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // determine the final day (datetime)
        $expired_at = Carbon::now()->endOfDay();

        // Forever save exchange rate in cache
        $exchangeRateUsd = cache()->remember('exchange_rate_usd',$expired_at ,function() {
            $client = new ExchangeRateUsdClient();
            return $client->exchangeRateToUsd();
        });
        
        // Register BD
        $this->payment->exchange_rate = $exchangeRateUsd;
        $this->payment->save();
    }
}
