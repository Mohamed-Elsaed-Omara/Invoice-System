<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();

        
        return view('invoices.archive_invoices',compact('invoices'));
        
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

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,)
    {
        Invoice::withTrashed()
        ->whereId($request->invoice_id)->restore();

        session()->flash('restore_invoice');
        return redirect('/archive');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delInvoiceFromArchive($id)
    {
        $invoice = Invoice::withTrashed()->whereId($id)->first();

        $invoice->forceDelete();

        session()->flash('delete_invoice');
        return redirect('/archive');
    }
}
