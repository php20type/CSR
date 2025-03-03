@extends('admin.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
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
</div>
@endsection
