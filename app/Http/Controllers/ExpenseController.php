<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ExpenseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id());

        if (request('status')) {
            $expenses->where('status', request('status'));
        }

        $expenses = $expenses->orderBy('id', 'DESC')->paginate(10);
        return view('users.index', compact('expenses'));
    }
    public function create()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return view('users.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'description' => 'required',
            'receipt' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);


        $user_id = Auth::user()->id;

        $expense = new Expense();
        $expense->user_id = $user_id;
        $expense->category_id = $request->category_id;
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->description = $request->description;

        if ($request->file('receipt')->isValid()) {
            $file = $request->file('receipt');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $request->receipt->move(public_path('uploads'), $fileName);
            $expense->receipt = $fileName;
        }
        $expense->save();
        return redirect()->route('expenses.index')->with('success', 'Expense submitted successfully');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($expense->status !== 'pending') {
            return back()->with('error', 'Only pending expenses can be deleted.');
        }

         if(File::exists(public_path('uploads/').'/'.$expense->receipt))
        {
            File::delete(public_path('uploads/').'/'.$expense->receipt);
        }

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
