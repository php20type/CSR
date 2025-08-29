@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-building"></i> Total NGOs</h5>
                    <h3>{{ $total_ngos }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-check-circle"></i> Approved NGOs</h5>
                    <h3>{{ $approved_ngos }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-clock"></i> Pending NGOs</h5>
                    <h3>{{ $pending_ngos }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-wallet"></i> Remaining Funds</h5>
                    <h3>₹{{ number_format($remaining_budget, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5><i class="fa fa-plus-circle"></i> Add New NGO</h5>
                    <a href="{{ route('ngos.create') }}" class="btn btn-primary">Add NGO</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5><i class="fa fa-file-invoice"></i> View Bills</h5>
                    <a href="{{ route('bills.index') }}" class="btn btn-success">View Bills</a>
                </div>
            </div>
        </div>
    </div>

    <!-- NGOs List -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h4>Recent NGOs</h4>
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Team Responsible</th>
                        <th>Status</th>
                        <th>Food Cost</th>
                        <th>Other Cost</th>
                        <th>Total Cost</th>
                        <th>Released By</th>
                        <th>Remaining Budget</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ngos as $ngo)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ngo->name }}</td>
                        <td>{{ $ngo->team_responsible }}</td>
                        <td>
                            <span class="badge bg-{{ $ngo->status == 'approved' ? 'success' : ($ngo->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($ngo->status) }}
                            </span>
                        </td>
                        <td>₹{{ number_format($ngo->total_cost, 2) }}</td>
                        <td>₹{{ number_format($ngo->other_costs, 2) }}</td>
                        <td>₹{{ number_format(($ngo->total_cost + $ngo->other_costs), 2) }}</td>
                        <td>{{ $ngo->releasedBy ? $ngo->releasedBy->name : 'Not Released Yet' }}</td>
                        <td>₹{{ number_format($ngo->remaining_budget, 2) }}</td>
                        <td>
                            <a href="{{ route('ngos.edit', $ngo->id) }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('ngos.destroy', $ngo->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
