@extends('admin.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Initial Fund Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('settings.updateInitialFund') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="initial_fund" class="form-label">Initial Fund</label>
                    <input type="number" name="initial_fund" id="initial_fund" class="form-control" value="{{ $initialFund }}" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
            </form>
        </div>
    </div>

    <!-- Additional Fund Section -->
    <div class="card">
        <div class="card-body">
            <h5>Additional Funds</h5>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addFundModal">
                <i class="fa fa-plus"></i> Add Additional Fund
            </button>

            <!-- Fund List -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Release Date</th>
                        <th>Added By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($additionalFund as $fund)
                        <tr>
                            <td>{{ number_format($fund->amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($fund->release_date)->format('d M Y') }}</td>
                            <td>{{ $fund->user->name ?? 'N/A' }}</td>
                            <td>
                                <!-- Edit button -->
                                <button class="btn btn-warning btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editFundModal{{ $fund->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <!-- Delete form -->
                                <form action="{{ route('fund.destroy', $fund->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            <!-- Edit Fund Modal -->
                            <div class="modal fade" id="editFundModal{{ $fund->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('fund.update', $fund->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Fund</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">Amount</label>
                                                    <input type="number" name="amount" class="form-control" value="{{ $fund->amount }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="release_date" class="form-label">Release Date</label>
                                                    <input type="date" name="release_date" class="form-control" value="{{ $fund->release_date }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="note" class="form-label">Note</label>
                                                    <input type="text" name="note" class="form-control" value="{{ $fund->note }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Fund</th>
                        <th>
                            {{ number_format($initialFund + $additionalFund->sum('amount'), 2) }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addFundModal" tabindex="-1" aria-labelledby="addFundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('fund.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFundModalLabel">Add Additional Fund</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="release_date" class="form-label">Release Date</label>
                        <input type="date" name="release_date" id="release_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note (optional)</label>
                        <input type="text" name="note" id="note" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Fund</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- <form action="{{ url('/send-test-mail') }}" method="GET">
    <button type="submit">Send Test Mail</button>
</form> --}}
@endsection
