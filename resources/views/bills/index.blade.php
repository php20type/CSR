@extends('admin.layout')

@section('content')
<h2>All Bills</h2>

@if($bills->isEmpty())
    <p>No bills available.</p>
@else
    <table border="1">
        <tr>
            <th>Bill Number</th>
            <th>NGO Name</th>
            <th>Amount</th>
            <th>File</th>
        </tr>
        @foreach($bills as $bill)
            <tr>
                <td>{{ $bill->bill_number }}</td>
                <td>{{ $bill->ngo->name }}</td>
                <td>${{ number_format($bill->amount, 2) }}</td>
                <td>
                    @if($bill->bill_file)
                        <a href="{{ asset('storage/' . $bill->bill_file) }}" target="_blank">View Bill</a>
                    @else
                        No File
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endif
@endsection
