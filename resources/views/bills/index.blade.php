@extends('admin.layout')

@section('style')
<style>
    .preview-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 500px;
        background: #f9f9f9;
    }
    .preview-container img {
        max-width: 100%;
        max-height: 80vh;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        object-fit: contain;
    }
    .preview-container iframe {
        width: 1000px;
        height: 80vh;
        border: none;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Bills</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bills->isEmpty())
        <div class="alert alert-info">No bills available.</div>
    @else
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Bill Number</th>
                    <th>NGO Name</th>
                    <th>Amount</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bills as $index => $bill)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $bill->bill_number }}</td>
                        <td>{{ $bill->ngo ? $bill->ngo->name : 'N/A' }}</td>
                        <td>₹{{ number_format($bill->amount, 2) }}</td>
                        <td>
                            @if($bill->bill_file)
                                <button type="button" 
                                    class="btn btn-sm btn-info" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#previewModal" 
                                    data-file="{{ asset('storage/' . $bill->bill_file) }}">
                                    Preview
                                </button>
                            @else
                                <span class="text-muted">No File</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('bills.delete', $bill->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this bill?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body preview-container">
                    <!-- Dynamic preview will be injected here -->
                    <div id="previewContent"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener("DOMContentLoaded", function() {
    var previewModal = document.getElementById('previewModal');
    var previewContent = document.getElementById('previewContent');

    previewModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var fileUrl = button.getAttribute('data-file');
        var extension = fileUrl.split('.').pop().toLowerCase();

        previewContent.innerHTML = ''; // Clear previous

        if(extension === 'pdf'){
            previewContent.innerHTML = `<iframe src="${fileUrl}#zoom=100"></iframe>`;
        } else if(['jpg','jpeg','png','gif','webp'].includes(extension)) {
            previewContent.innerHTML = `<img src="${fileUrl}" alt="Bill Image" />`;
        } else {
            previewContent.innerHTML = `<p class="text-muted">File type not supported for preview. <a href="${fileUrl}" target="_blank">Download</a></p>`;
        }
    });

    previewModal.addEventListener('hidden.bs.modal', function () {
        previewContent.innerHTML = '';
    });
});
</script>
@endsection
