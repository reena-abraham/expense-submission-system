@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Expense Details</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Expense Details</div>
                    </li>
                </ul>
            </div>



            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Employee Details</h5>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.index') }}">Back</a>
                </div>
                <div class="table-responsive">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Employee Code</th>
                                <td>{{ $expense->user->emp_code }}</td>
                                <th>Employee Name</th>
                                <td>{{ $expense->user->name }}</td>
                                <th>Employee Email</th>
                                <td>{{ $expense->user->email }}</td>
                            </tr>


                        </thead>

                    </table>
                </div>


            </div>

            <div class="wg-box mt-5">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Expenses</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Titile</th>
                                <td>{{ $expense->title }}</td>
                                <th>Category</th>
                                <td>{{ $expense->category->name }}</td>
                                <th>Amount</th>
                                <td>{{ $expense->amount }}</td>

                            </tr>
                            <tr>

                                <th>Expense Status</th>
                                <td>
                                    @if ($expense->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($expense->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <th>Receipt</th>
                                <td>
                                    @if ($expense->receipt)
                                        <a href="{{ asset('uploads/' . $expense->receipt) }}" target="_blank">View
                                            Receipt</a>
                                    @endif
                                </td>

                            </tr>
                            <tr>
                                <th colspan="6">Description</th>
                            </tr>
                            <tr>
                                <td colspan="6">{{ $expense->description }}</td>
                            </tr>


                        </thead>

                    </table>
                </div>


            </div>

            <div class="wg-box mt-5">
                <h5>Update Expense Status</h5>
                <form action="{{ route('admin.expense.status.update') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="expense_id" value="{{ $expense->id }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="select">
                                <select id="expense_status" name="expense_status">
                                    <option value="pending" {{ $expense->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved" {{ $expense->status == 'approved' ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="rejected" {{ $expense->status == 'rejected' ? 'selected' : '' }}>Rejected
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary tf-button w208">Update Status</button>
                        </div>
                    </div>
            </div>



        </div>
    </div>
@endsection
