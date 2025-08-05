<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate(Expense::rules());

        $path = $request->file('receipt') ? $request->file('receipt')->store('receipts') : null;

        Expense::create([
            'user_id' => Auth::user()->id,
            'amount' => $request->amount,
            'description' => $request->description,
            'status' => 'pending',
            'receipt' => $path,
        ]);

        return redirect()->route('expenses.index');
    }

    // Admin view all expenses
    public function index()
    {
        $expenses = Expense::with('user')->get();
        return view('expenses.index', compact('expenses'));
    }

    // User can view their own expenses
    public function userExpenses()
    {
        $expenses = Expense::where('user_id', Auth::user()->id)->get();
        return view('expenses.index', compact('expenses'));
    }
}
