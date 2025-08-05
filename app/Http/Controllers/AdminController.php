<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // $expenses = Expense::orderBy('created_at','DESC')->paginate(4);
        $expenses = Expense::query();

        if (request('status')) {
            $expenses->where('status', request('status'));
        }

        $expenses = $expenses->orderBy('created_at', 'DESC')->paginate(4);

        return view('admin.index',compact('expenses'));
    }
    public function categories()
    {
        $categories = Category::orderBy('id','DESC')->paginate(10);
        return view('admin.categories',compact('categories'));
    }
    public function category_add()
    {
        return view('admin.category-add');
    }
    public function category_store(Request $request)
    {
        $request->validate([
            'name'=>'required',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return redirect()->route('admin.categories')->with('status','Category has been added successfully');

    }
    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit',compact('category'));
    }
    public function category_update(Request $request)
    {
        $request->validate([
                    'name'=>'required',
                ]);
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->save();
        return redirect()->route('admin.categories')->with('status','Category has been updated successfully');
    }
    public function category_delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('admin.categories')->with('status','Category deleted successfully');

    }
    public function expense_details($id)
    {
        $expense = Expense::find($id);
        return view('admin.expense_details',compact('expense'));
    }
    public function update_expense_status(Request $request)
    {
        $expense = Expense::find($request->expense_id);
        $expense->status = $request->expense_status;
        $expense->save();

        return back()->with('status',"Status changed successfully");
    }
}
