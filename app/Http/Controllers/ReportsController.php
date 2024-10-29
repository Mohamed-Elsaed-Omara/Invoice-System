<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function searchReport(Request $request)
    {

        
        $invoices = Invoice::query();
        if($request->rdio == '1'){
            
            if($request->type){
                $invoices = $invoices->where('status',$request->type);
            }
    
            /* if($request->start_at){
                $invoices = $invoices->whereDate('invoice_date',$request->start_at);
            }
    
            if($request->end_at){
                $invoices = $invoices->whereDate('due_date',$request->end_at);
            } */

            if($request->start_at && $request->end_at){
                $invoices = $invoices->whereBetween('invoice_date',[$request->start_at,$request->end_at]);
            }
        }
        else{
            if($request->invoice_number){
                $invoices = $invoices->where('invoice_number',$request->invoice_number);
            }
        }

        
        $invoices = $invoices->latest()->get();

        $request->flash();

        return view('reports.index',compact('invoices'));

    }
}
