@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Edit NGO</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('ngos.update', $ngo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>NGO Name</strong></label>
                        <input type="text" name="name" class="form-control" value="{{ $ngo->name }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Team Responsible</strong></label>
                        <input type="text" name="team_responsible" class="form-control" value="{{ $ngo->team_responsible }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Food Type</strong></label>
                        <input type="text" name="food_type" class="form-control" value="{{ $ngo->food_type }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Quantity</strong></label>
                        <input type="number" name="quantity" class="form-control" value="{{ $ngo->quantity }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Cost per Unit</strong></label>
                        <input type="number" name="cost_per_unit" class="form-control" value="{{ $ngo->cost_per_unit }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Other Costs</strong></label>
                        <input type="number" name="other_costs" class="form-control" value="{{ $ngo->other_costs }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Total Cost</strong></label>
                        <input type="number" name="total_cost" class="form-control" value="{{ $ngo->total_cost }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Payment Mode</strong></label>
                        <select name="payment_mode" class="form-control" required>
                            <option value="cash" {{ $ngo->payment_mode == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ $ngo->payment_mode == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="online" {{ $ngo->payment_mode == 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Released By</strong></label>
                        <select name="released_by" class="form-control">
                            <option value="">-- Select User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $ngo->released_by == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label"><strong>Remarks</strong></label>
                        <textarea name="remarks" class="form-control" rows="3">{{ $ngo->remarks }}</textarea>
                    </div>

                    <!-- Bill Upload -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label"><strong>Upload Bill Files (PDF only, multiple allowed)</strong></label>
                        <input type="file" name="bill_files[]" class="form-control" accept="application/pdf" multiple>
                    </div>

                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Update NGO
                </button>

                <a href="{{ route('ngos.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to List
                </a>
            </form>

            <!-- Display Existing Bills -->
            @if($ngo->bills->count() > 0)
                <div class="col-md-12 mt-4">
                    <label class="form-label"><strong>Existing Bills</strong></label>
                    <ul class="list-group">
                        @foreach($ngo->bills as $bill)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ asset('storage/' . $bill->bill_file) }}" target="_blank">{{ $bill->bill_number }}</a>
                                <form action="{{ route('bills.delete', $bill->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
