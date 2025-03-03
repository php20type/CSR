@extends('admin.layout')
@section('content')
<div class="container">
    <h2>Settings</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('settings.updateInitialFund') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="initial_fund" class="form-label">Initial Fund</label>
            <input type="number" name="initial_fund" id="initial_fund" class="form-control" value="{{ $initialFund }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
