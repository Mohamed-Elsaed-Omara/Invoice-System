<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Models\Invoice_details;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateInvoiceDetails
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InvoiceCreated $event): void
    {
        $invoice = $event->invoice;

        $existingInvoice = Invoice_details::where('invoice_id', $invoice->id)
                                ->where('invoice_number', $invoice->invoice_number)
                                ->first();
        if(!$existingInvoice){

            Invoice_details::create([
    
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'product' => $invoice->product,
                'section' => $invoice->section_id,
                'status' => 2,
                'note' => $invoice->note,
                'user' => auth()->user()->name,
            ]);
        }
    }
}
