<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        // $expenses = Expense::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(4);
        // $expenses = Expense::where('user_id', Auth::user()->id)
        //             ->when(request('status'), function ($query) {
        //                 return $query->where('status', request('status'));
        //             })
        //             ->orderBy('id', 'DESC')
        //             ->paginate(4);
        // $expenses = Expense::where('user_id', Auth::id())
        //            ->where('status', request('status') ?: '!=', 'NULL') // Apply filter only if status is provided
        //            ->orderBy('id', 'DESC')
        //            ->paginate(4);
        $expenses = Expense::where('user_id', Auth::id());

        if (request('status')) {
            $expenses->where('status', request('status'));
        }

        $expenses = $expenses->orderBy('id', 'DESC')->paginate(4);
        return view('users.index', compact('expenses'));
    }
    public function create()
    {
        $categories = Category::select('id','name')->orderBy('name')->get();
        return view('users.create',compact('categories'));
    }
     public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=>'required',
            'category_id'=>'required',
            'amount' => 'required|numeric|min:0',
            'description' => 'required',
            'receipt' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);


        $user_id = Auth::user()->id;

        $expense = new Expense();
        $expense->user_id = $user_id;
        $expense->category_id=$request->category_id;
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->description = $request->description;

        if ($request->file('receipt')->isValid()) {
            $file = $request->file('receipt');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            // $filePath = $file->storeAs('uploads/', $fileName, 'public');
            $request->receipt->move(public_path('uploads'), $fileName);
            $expense->receipt = $fileName;
        }
        $expense->save();
        return redirect()->route('expenses.index')->with('success', 'Expense submitted.');
    }

}
