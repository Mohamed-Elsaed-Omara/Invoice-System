<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Models\Invoice_attachments;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;

class CreateInvoiceAttachments
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
        $request = $event->request;
        if($request->hasFile('pic')){

            $fileName = now()->timestamp .'_'. $request->file('pic')->getClientOriginalName();

            $filePath = "uploads/attachments/" . $fileName;

            $request->file('pic')->move('uploads/attachments/',$fileName);

            Invoice_attachments::create([
                'file_name' => $fileName,
                'invoice_number' => $invoice->invoice_number,
                'invoice_id' => $invoice->id,
                'created_by' => auth()->user()->name,
            ]);
        }
        
        
    }
}
