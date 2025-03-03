@extends('admin.layout')

@section('style')
<style>
    table {
        table-layout: fixed;
        width: 100%;
    }

    th, td {
        white-space: nowrap;
        overflow: hidden;
        /* text-overflow: ellipsis; */
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        justify-content: center;
    }

    .action-buttons button {
        padding: 5px 10px;
        font-size: 12px;
    }

</style>    
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>NGOs Fund Management</h2>
        <p><strong>Initial Fund:</strong> ₹{{ number_format($initialFund, 2) }}</p>
        <p><strong>Remaining Fund:</strong> ₹{{ number_format($remainingBudget, 2) }}</p>
        <a href="{{ route('ngos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add NGO
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Team Responsible</th>
                        <th>Food Type</th>
                        {{-- <th>Food Cost</th>
                        <th>Other Cost</th> --}}
                        <th>Total Cost</th>
                        <th>Payment Mode</th>
                        <th>Remaining Budget</th>
                        <th>Approvals</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ngos as $ngo)
                    <tr>
                        <td>{{ $ngo->name }}</td>
                        <td>{{ $ngo->team_responsible }}</td>
                        <td>{{ $ngo->food_type }}</td>
                        {{-- <td>₹{{ number_format($ngo->total_cost, 2) }}</td>
                        <td>₹{{ number_format($ngo->other_costs, 2) }}</td> --}}
                        <td>₹{{ number_format($ngo->other_costs + $ngo->total_cost, 2) }}</td>
                        <td>{{ $ngo->payment_mode }}</td>
                        <td>₹{{ number_format($ngo->remaining_budget, 2) }}</td>
                        <td>
                            <!-- Get approved admins -->
                            @php
                                $approvedAdmins = $ngo->approvals->pluck('admin_id')->toArray();
                                $pendingAdmins = $admins->whereNotIn('id', $approvedAdmins);
                            @endphp
                            <!-- Show approved admins -->
                            @foreach($ngo->approvals as $approval)
                                ✅ {{ $approval->admin->name }}<br>
                            @endforeach
                            @foreach($pendingAdmins as $pending)
                                ❌ {{ $pending->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge bg-{{ $ngo->status == 'Done' ? 'success' : 'warning' }}">
                                {{ ucfirst($ngo->status) }}
                            </span>
                        </td>
                        <td>
                            @if($ngo->status != 'Done' && !$ngo->approvals->contains('admin_id', auth()->id()))
                                <form action="{{ route('ngos.approve', $ngo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                            @else
                                <span class="text-success">Approved</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('ngos.edit', $ngo->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('ngos.destroy', $ngo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                            </form>
                            {{-- <a href="{{ route('ngos.show', $ngo->id) }}">Edit</a> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
