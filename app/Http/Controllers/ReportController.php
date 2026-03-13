<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $transactions = Transaction::orderBy('date', 'desc')->get();

        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $saldo = $totalIncome - $totalExpense;

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'saldo'
        ));

        return $pdf->stream('laporan-keuangan.pdf');
    }
}