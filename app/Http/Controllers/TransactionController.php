<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $month = request('month');
        $year = request('year');
        $query = Transaction::query();
        if ($month && $year) {
            $query->whereMonth('date', $month)->whereYear('date', $year);
        }
        $income = (clone $query)->where('type', 'income')->sum('amount');
        $expense = (clone $query)->where('type', 'expense')->sum('amount');
        $balance = $income - $expense;
        $count = (clone $query)->count();
        $latest = (clone $query)->orderBy('date', 'desc')->take(10)->get();

        $chartLabels = [];
        $chartIncome = [];
        $chartExpense = [];
        $now = Carbon::now();
        for ($i = 5; $i >= 0; $i--) {
            $d = $now->copy()->subMonths($i);
            $m = $d->month;
            $y = $d->year;
            $chartLabels[] = $d->format('M Y');
            $chartIncome[] = Transaction::whereMonth('date', $m)->whereYear('date', $y)->where('type', 'income')->sum('amount');
            $chartExpense[] = Transaction::whereMonth('date', $m)->whereYear('date', $y)->where('type', 'expense')->sum('amount');
        }

        $currentMonth = $now->month;
        $currentYear = $now->year;
        $previousMonthDate = $now->copy()->subMonth();
        $previousMonth = $previousMonthDate->month;
        $previousYear = $previousMonthDate->year;
        $currentIncome = Transaction::where('type', 'income')->whereMonth('date', $currentMonth)->whereYear('date', $currentYear)->sum('amount');
        $currentExpense = Transaction::where('type', 'expense')->whereMonth('date', $currentMonth)->whereYear('date', $currentYear)->sum('amount');
        $previousIncome = Transaction::where('type', 'income')->whereMonth('date', $previousMonth)->whereYear('date', $previousYear)->sum('amount');
        $previousExpense = Transaction::where('type', 'expense')->whereMonth('date', $previousMonth)->whereYear('date', $previousYear)->sum('amount');
        $incomePercentage = $this->calculatePercentage($currentIncome, $previousIncome);
        $expensePercentage = $this->calculatePercentage($currentExpense, $previousExpense);

        return view('dashboard', compact(
            'income',
            'expense',
            'balance',
            'count',
            'latest',
            'chartLabels',
            'chartIncome',
            'chartExpense',
            'currentIncome',
            'currentExpense',
            'incomePercentage',
            'expensePercentage'
        ));
    }

    private function calculatePercentage($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return (($current - $previous) / $previous) * 100;
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:income,expense'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ]);

        Transaction::create($validated);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dihapus');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:income,expense'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update($validated);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function exportPdf()
    {
        return response('Export PDF belum diimplementasikan', 200);
    }
}
