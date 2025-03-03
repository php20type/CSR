@extends('admin.layout')
@section('content')
<div class="container">
    <h2>Add NGO</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('ngos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">NGO Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Team Responsible</label>
                    <input type="text" name="team_responsible" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Type of Food Distributed</label>
                    <input type="text" name="food_type" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cost per Unit</label>
                    <input type="number" step="0.01" name="cost_per_unit" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Other Costs</label>
                    <input type="number" step="0.01" name="other_costs" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Cost</label>
                    <input type="number" step="0.01" name="total_cost" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Mode</label>
                    <select name="payment_mode" class="form-control" required>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Online Payment">Online Payment</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Bill Number (Optional)</label>
                    <input type="text" name="bill_number" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bill Amount (Optional)</label>
                    <input type="number" name="amount" step="0.01" class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label"><strong>Upload Bill Files (PDF only, multiple allowed)</strong></label>
                    <input type="file" name="bill_files[]" class="form-control" accept="application/pdf" multiple>
                </div>

                {{-- <div class="mb-3">
                    <label class="form-label">Remaining Budget</label>
                    <input type="number" step="0.01" name="remaining_budget" class="form-control" required>
                </div> --}}

                <div class="mb-3">
                    <label class="form-label">Remarks/Notes</label>
                    <textarea name="remarks" class="form-control"></textarea>
                </div>
                

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
