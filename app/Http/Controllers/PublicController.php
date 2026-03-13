<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class PublicController extends Controller
{

    public function index()
    {
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $saldo = $totalIncome - $totalExpense;

        $monthlyIncome = Transaction::where('type', 'income')
            ->whereMonth('date', Carbon::now()->month)
            ->sum('amount');

        $monthlyExpense = Transaction::where('type', 'expense')
            ->whereMonth('date', Carbon::now()->month)
            ->sum('amount');

        $latestTransactions = Transaction::latest()->take(5)->get();

        return view('public.laporan', compact(
            'saldo',
            'monthlyIncome',
            'monthlyExpense',
            'latestTransactions'
        ));
    }
}
