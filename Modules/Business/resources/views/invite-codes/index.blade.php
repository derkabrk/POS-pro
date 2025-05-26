@extends('business::layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Invite Codes</h5>
            <a href="{{ route('business.invite-codes.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="ri-add-line me-1"></i> New Invite Code
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Status</th>
                            <th>Expires At</th>
                            <th>Used By</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($codes as $code)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold text-monospace">{{ $code->code }}</td>
                            <td>
                                @if($code->used)
                                    <span class="badge bg-danger rounded-pill">Used</span>
                                @elseif($code->expires_at && $code->expires_at->isPast())
                                    <span class="badge bg-secondary rounded-pill">Expired</span>
                                @else
                                    <span class="badge bg-success rounded-pill">Active</span>
                                @endif
                            </td>
                            <td>{{ $code->expires_at ? $code->expires_at->format('Y-m-d H:i') : '-' }}</td>
                            <td>{{ $code->used_by ?? '-' }}</td>
                            <td>{{ $code->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $codes->links() }}
        </div>
    </div>
</div>
@endsection
