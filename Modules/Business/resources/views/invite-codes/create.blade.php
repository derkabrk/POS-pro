@extends('business::layouts.master')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0"><i class="ri-add-line me-1"></i> Create Invite Code</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('business.invite-codes.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Expires At (optional)</label>
                            <input type="datetime-local" name="expires_at" class="form-control rounded-pill">
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('business.invite-codes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                            <button class="btn btn-primary rounded-pill px-4"><i class="ri-save-3-line me-1"></i> Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
