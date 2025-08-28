@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Bills</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bills->isEmpty())
        <div class="alert alert-info">No bills available.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Bill Number</th>
                    <th>NGO Name</th>
                    <th>Amount</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bills as $index => $bill)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $bill->bill_number }}</td>
                        <td>{{ $bill->ngo ? $bill->ngo->name : 'N/A' }}</td>
                        <td>${{ number_format($bill->amount, 2) }}</td>
                        <td>
                            @if($bill->bill_file)
                                <a href="{{ asset('storage/' . $bill->bill_file) }}" target="_blank" class="btn btn-sm btn-info">
                                    View
                                </a>
                            @else
                                <span class="text-muted">No File</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('bills.delete', $bill->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this bill?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
