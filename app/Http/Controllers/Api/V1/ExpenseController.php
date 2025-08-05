<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $expenses = $user->expenses()->latest()->paginate(2);
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized: token missing or invalid.'
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $expenses
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
        'title' => 'required',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'description' => 'required',
            'receipt' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 200,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ]);
    }

        $expense = new Expense();
        $expense->user_id = Auth::id();
        $expense->category_id=$request->category_id;
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

        return response()->json([
            'status' => 200,
            'message' => 'Expense submitted successfully',
        ]);
    }

    public function show($id)
    {
        $expense = Expense::find($id);

        if ($expense->user_id !== Auth::id()) {
            return response()->json(['status'=>401,'message' => 'Unauthorized']);
        }

        return response()->json([
            'status' => 200,
            'data' => $expense,
        ]);
    }
    public function categories()
    {
        $categories = Category::all();
        if($categories->isEmpty())
        {
            return response()->json([
                'status' => 404,
                'message' => 'No categories found'
            ]);

        }else{
             return response()->json([
                'status' => 200,
                'data' => $categories
            ]);
        }
    }
}
