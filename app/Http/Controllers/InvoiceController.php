<?php

namespace App\Http\Controllers;

use App\Events\InvoiceCreated;
use App\Models\Invoice;
use App\Models\Invoice_details;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices' ,compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $invoice = Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_vat' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'total' => $request->Total,
            'status' => '2',
            'note' => $request->note,
            'user' => auth()->user()->name,
        ]);

        event(new InvoiceCreated($invoice,$request));

        return back()->with('success','تم حفظ الفاتورة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Invoice::with('section')->find($id);
        return view('invoices.payment',compact('invoice'));
    }

    public function paymentChange(Request $request)
    {
        $invoice = Invoice::find($request->invoice_id);

        $upInvoice = $invoice->update([
            'status' => $request->Status,
            'payment_date' => $request->Payment_Date,
        ]);


        if($upInvoice){

            Invoice_details::create([
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'product' => $invoice->product,
                'section' => $invoice->section_id,
                'status' => $request->Status,
                'note' => $invoice->note,
                'user' => auth()->user()->name,
            ]);
        }
        session()->flash('status_update');
        return redirect('/invoices');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteInvoice($invoiceId)
    {
        Invoice::findOrFail($invoiceId)->Delete();

        return back()->with('delete_invoice','تم حذف الفاتورة بنجاح');
    }

    public function getProducts($id)
    {
        $products = DB::table("products")->where('section_id',$id)->pluck("name","id");

        return json_encode($products);
    }
    
    public function InvoicePaid()
    {
        $paid = Invoice::PAID;
        $invoices = Invoice::where('status', $paid)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }


    public function InvoiceUnPaid()
    {
        $unPaid = Invoice::UNPAID;

        $invoices = Invoice::where('status',$unPaid)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }

    public function InvoicePartial()
    {
        $partiallPaid = Invoice::PARTIALLYPAID;

        $invoices = Invoice::where('status',$partiallPaid)->get();
        return view('invoices.invoices_partialpaid',compact('invoices'));
    }

    public function archiveInvoice($id)
    {
        Invoice::find($id)->delete();

        session()->flash('invoice_archive');
        return redirect('/invoices');
    }

    public function printInvoice($id)
    {
        $invoice = Invoice::find($id);

        return view('invoices.print_invoice',compact('invoice'));
    }

    public function export() 
    {
        return Excel::download(new InvoicesExport, 'users.xlsx');
    }


}
