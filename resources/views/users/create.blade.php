@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Submit Expense</h2>
        <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row"> <!-- Add this row wrapper -->
                <div class="mb-3 col-md-6">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="form-control @error('title') is-invalid @enderror" autocomplete="off">

                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label>Category</label>
                    <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                        <option value="">Choose category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label>Amount</label>
                    <input type="number" name="amount" class="form-control  @error('amount') is-invalid @enderror"
                        value="{{ old('amount') }}" autocomplete="off">
                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label>Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label>Receipt</label>
                    <input type="file" name="receipt" class="form-control @error('receipt') is-invalid @enderror">
                    @error('receipt')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> <!-- end row -->

            <button class="btn btn-success">Submit</button>
        </form>
    </div>

    <div class="container " style="display: none">
        <h2>Submit Expense</h2>
        <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 col-md-6">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control">

                @error('title')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label>Category</label>
                <select class="form-control" name="category_id">
                    <option>Choose category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach

                </select>

                @error('title')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label>Amount</label>
                <input type="number" name="amount" class="form-control">
                @error('amount')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
                {{-- <input type="text" name="description" class="form-control"> --}}
                @error('description')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label>Receipt</label>
                <input type="file" name="receipt" class="form-control">
                @error('receipt')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection
