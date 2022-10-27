<?php

namespace App\Observers;

use App\Models\Payment;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use App\Mail\CreatedPaymentNotificationMailable;
use App\Jobs\RegisterExchangeRateJob;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        try {

            RegisterExchangeRateJob::dispatch($payment);
            
            // Class CreatedPaymentNotificationMailable to implements class ShouldQueue, to always send emails through queue 
            $destination_email = $payment->client->email;
            Mail::to($destination_email)->send(new CreatedPaymentNotificationMailable());

        } catch (ClientException $e) {
            Log::error($e->getResponse()->getBody()->getContents());
        }

    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function restored(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
        //
    }
}
