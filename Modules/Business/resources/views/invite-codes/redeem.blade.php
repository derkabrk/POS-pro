@extends('business::layouts.master')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0"><i class="ri-key-line me-1"></i> Redeem Invite Code</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('business.invite-codes.redeem') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Invite Code</label>
                            <input type="text" name="code" class="form-control rounded-pill" required placeholder="Enter your invite code">
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button class="btn btn-primary rounded-pill px-4"><i class="ri-check-line me-1"></i> Redeem</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
