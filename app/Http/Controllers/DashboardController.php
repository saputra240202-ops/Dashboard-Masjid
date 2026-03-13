<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get dashboard data with comprehensive calculations
     */
    private function getDashboardData(?Request $request = null)
    {
        // Get filter parameters
        $month = $request?->month ?: null;
        $year = $request?->year ?: null;
        
        // Base query for transactions
        $transactionQuery = Transaction::query();
        
        // Apply filters if provided
        if ($month) {
            $transactionQuery->whereMonth('date', $month);
        }
        
        if ($year) {
            $transactionQuery->whereYear('date', $year);
        }
        
        // Total calculations
        $totalIncome = (clone $transactionQuery)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $transactionQuery)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        $transactionCount = $transactionQuery->count();
        
        // Current month calculations
        $currentMonthIncome = Transaction::where('type', 'income')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');
            
        $currentMonthExpense = Transaction::where('type', 'expense')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');
        
        // Previous month calculations for percentage changes
        $previousMonthIncome = Transaction::where('type', 'income')
            ->whereMonth('date', Carbon::now()->subMonth()->month)
            ->whereYear('date', Carbon::now()->subMonth()->year)
            ->sum('amount');
            
        $previousMonthExpense = Transaction::where('type', 'expense')
            ->whereMonth('date', Carbon::now()->subMonth()->month)
            ->whereYear('date', Carbon::now()->subMonth()->year)
            ->sum('amount');
        
        // Percentage calculations
        $incomePercentage = $previousMonthIncome > 0 
            ? (($currentMonthIncome - $previousMonthIncome) / $previousMonthIncome) * 100 
            : 0;
            
        $expensePercentage = $previousMonthExpense > 0 
            ? (($currentMonthExpense - $previousMonthExpense) / $previousMonthExpense) * 100 
            : 0;
        
        // Latest transactions
        $latestTransactions = $transactionQuery->latest()->take(10)->get();
        
        // Chart data - Last 6 months trend
        $chartData = [];
        $chartLabels = [];
        $chartIncome = [];
        $chartExpense = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M Y');
            $chartLabels[] = $monthName;
            
            $monthIncome = Transaction::where('type', 'income')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
                
            $monthExpense = Transaction::where('type', 'expense')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
                
            $chartIncome[] = $monthIncome;
            $chartExpense[] = $monthExpense;
        }
        
        return [
            'income' => $totalIncome,
            'expense' => $totalExpense,
            'balance' => $balance,
            'count' => $transactionCount,
            'currentIncome' => $currentMonthIncome,
            'currentExpense' => $currentMonthExpense,
            'incomePercentage' => $incomePercentage,
            'expensePercentage' => $expensePercentage,
            'latest' => $latestTransactions,
            'chartLabels' => $chartLabels,
            'chartIncome' => $chartIncome,
            'chartExpense' => $chartExpense,
            'filterMonth' => $month,
            'filterYear' => $year,
        ];
    }
    
    /**
     * Admin dashboard
     */
    public function index(Request $request)
    {
        $data = $this->getDashboardData($request);
        $data['isPublic'] = false;
        
        return view('dashboard', $data);
    }
    
    /**
     * Public dashboard (read-only)
     */
    public function public()
    {
        $data = $this->getDashboardData();
        $data['isPublic'] = true;
        
        return view('dashboard', $data);
    }
}
