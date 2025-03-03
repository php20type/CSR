@extends('admin.layout')

@section('content')
<h2>{{ $ngo->name }} Details</h2>

<p><strong>Team Responsible:</strong> {{ $ngo->team_responsible }}</p>

<h3>Bills</h3>

@if($ngo->bills->isEmpty())
    <p>No bills available.</p>
@else
    <table border="1">
        <tr>
            <th>Bill Number</th>
            <th>Amount</th>
            <th>File</th>
        </tr>
        @foreach($ngo->bills as $bill)
            <tr>
                <td>{{ $bill->bill_number }}</td>
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

<a href="{{ route('ngos.index') }}">Back to List</a>
@endsection
