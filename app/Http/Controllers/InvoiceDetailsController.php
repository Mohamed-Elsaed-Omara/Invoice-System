<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_attachments;
use App\Models\Invoice_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Invoice::with(['invoiceDetails','invoiceAttachments'])->find($id);

        return view('invoices.details_invoice',compact('invoice'));

        
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice_details $invoice_details)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice_details $invoice_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice_details $invoice_details)
    {
        //
    }

    public function getViewFile($fileName)
    {
        $filePath = 'uploads/attachments/' . $fileName;
        $file = public_path($filePath);

        return response()->file($file);
    }
    
    public function downFile($fileName)
    {
        $filePath = 'uploads/attachments/' . $fileName;
        $file = public_path($filePath);

        return response()->download($file);
    }

    public function deleteFile($fileId)
    {
        $invoiceAttach = Invoice_attachments::findOrFail($fileId);
        
        Storage::disk('public_uploads')->delete($invoiceAttach->file_name);

        $invoiceAttach->delete();

        return back()->with('success','تم حذف المرفق بنجاح');
    }
}
