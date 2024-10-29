<?php

namespace App\Http\Controllers;

use App\Models\Invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentsController extends Controller
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
        $request->validate([
            'file_name'=> 'required|mimes:pdf,jpeg,png,jpg',
        ],[
            'file_name.required' => 'هذا الحقل مطلوب',
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        if($request->hasFile('file_name')){
            $fileName = now()->timestamp .'_'. $request->file('file_name')->getClientOriginalName();
            $filePath = "uploads/attachments/" . $fileName;

            $request->file('file_name')->move('uploads/attachments/', $fileName);

            Invoice_attachments::create([
                'file_name' => $fileName,
                'invoice_id' => request()->invoice_id,
                'invoice_number' => request()->invoice_number,
                'created_by' => auth()->user()->name,
            ]);
        }

        return back()->with('Add' ,'تم اضافة المرفق بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice_attachments $invoice_attachments)
    {
        //
    }

}
