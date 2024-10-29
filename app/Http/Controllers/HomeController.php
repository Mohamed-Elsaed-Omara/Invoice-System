<?php

namespace App\Http\Controllers;

use ConsoleTVs\Charts\Facades\Charts;
use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $count_all = Invoice::count();
        $countInvoicesPaid = Invoice::where('status', Invoice::PAID)->count();
        $countInvoicesUnPaid = Invoice::where('status', Invoice::UNPAID)->count();
        $countInvoicesPartiallyPaid = Invoice::where('status', Invoice::PARTIALLYPAID)->count();

        if ($countInvoicesUnPaid == 0) {
            $nspainvoices2 = 0;
        } else {
            $nspainvoices2 = $countInvoicesUnPaid / $count_all * 100;
        }

        if ($countInvoicesPaid == 0) {
            $nspainvoices1 = 0;
        } else {
            $nspainvoices1 = $countInvoicesPaid / $count_all * 100;
        }

        if ($countInvoicesPartiallyPaid == 0) {
            $nspainvoices3 = 0;
        } else {
            $nspainvoices3 = $countInvoicesPartiallyPaid / $count_all * 100;
        }

        /* $chartjs = Charts::create('bar', 'chartjs')
            ->title("My chart")
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->values([$nspainvoices2, $nspainvoices1, $nspainvoices3])
            ->dimensions(1000, 500)
            ->responsive(false); */

        return view('index', compact('chartjs', 'chartjs_2'));
    }
}
