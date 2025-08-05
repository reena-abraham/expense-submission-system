@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>My Expenses</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="text-end mb-3">
            <a href="{{ route('expenses.create') }}" class="btn btn-primary">New Expense</a>
        </div>

        <form method="GET" action="{{ route('expenses.index') }}">
            <div class="form-group">
                <label for="status">Filter by Status:</label>
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $expense->title }}</td>
                        <td>{{ $expense->category->name }}</td>
                        <td>{{ $expense->amount }}</td>
                        <td>
                            @php
                                $maxWords = 15;
                                $descriptionWords = str_word_count(strip_tags($expense->description));
                            @endphp

                            @if ($descriptionWords > $maxWords)
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#descModal-{{ $expense->id }}">{{ \Illuminate\Support\Str::words($expense->description, 8, '...') }}</a>

                                <!-- Modal -->
                                <div class="modal fade" id="descModal-{{ $expense->id }}" tabindex="-1"
                                    aria-labelledby="descModalLabel-{{ $expense->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="descModalLabel-{{ $expense->id }}">Description
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $expense->description }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{ $expense->description }}
                            @endif
                        </td>
                        <td>
                            @if ($expense->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($expense->status == 'rejected')
                                <span class="badge bg-danger">rejected</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if ($expense->receipt)
                                <a href="{{ asset('uploads/' . $expense->receipt) }}" target="_blank">View Receipt</a>
                            @endif
                        </td>

                        <td>
                            @if ($expense->status === 'pending' && $expense->user_id === auth()->id())
                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm delete">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
            {{ $expenses->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
@push('scripts')
    <script>
        $(function() {
            $('.delete').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this record?",
                    icon: "warning",
                    buttons: ["No", "Yes"],
                    confirmButtonColour: "#dc3545",
                }).then(function(result) {
                    if (result) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
