<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return view('reports.customers_report',compact('sections'));
    }

    public function searchReport(Request $request)
    {
        $sections = Section::all();        
        $invoices = Invoice::query();

        /* if($request->Section){
            $invoices = $invoices->where('section_id',$request->Section);
        }
        if($request->product){
            $invoices = $invoices->where('product',$request->product);
        } */
        if($request->Section && $request->product){
            $invoices = $invoices->where('section_id',$request->Section)
            ->where('product',$request->product);
        }
        if($request->start_at && $request->end_at){
            $invoices = $invoices->whereBetween('invoice_date',[$request->start_at,$request->end_at]);
        }
        
        $invoices = $invoices->latest()->get();

        $request->flash();

        return view('reports.customers_report',compact('invoices','sections'));

    }
}
