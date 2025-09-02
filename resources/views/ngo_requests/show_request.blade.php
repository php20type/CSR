@extends('admin.layout')

@section('content')
<div class="container">
    <h2>All Fund Requests</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>NGO Name</th>
                <th>Cost</th>
                <th>Note</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $req)
                <tr>
                    <td>{{ $req->name }}</td>
                    <td>{{ $req->email }}</td>
                    <td>{{ $req->phone }}</td>
                    <td>{{ $req->ngo_name }}</td>
                    <td>{{ $req->cost }}</td>
                    <td>{{ $req->note }}</td>
                    <td>{{ $req->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $requests->links() }}
</div>
@endsection
