@extends('business::layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Invite Codes</h5>
            <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#inviteCodeCreateModal">
                <i class="ri-add-line me-1"></i> Add Invite Code
            </button>
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
                            <td class="fw-bold text-monospace">{{ $code->code }}
                                <div class="mt-1 d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-0 copy-invite-code" data-code="{{ $code->code }}" title="Copy to clipboard"><i class="ri-file-copy-line"></i></button>
                                    <a class="btn btn-sm btn-outline-success rounded-pill px-2 py-0" href="mailto:?subject=Join%20with%20Invite%20Code&body=Use%20this%20invite%20code:%20{{ $code->code }}" title="Share via Email"><i class="ri-mail-send-line"></i></a>
                                    <a class="btn btn-sm btn-outline-info rounded-pill px-2 py-0" href="https://wa.me/?text=Use%20this%20invite%20code:%20{{ $code->code }}" target="_blank" title="Share via WhatsApp"><i class="ri-whatsapp-line"></i></a>
                                </div>
                            </td>
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

<!-- Invite Code Create Modal -->
<div class="modal fade" id="inviteCodeCreateModal" tabindex="-1" aria-labelledby="inviteCodeCreateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg border-0">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-bold mb-0" id="inviteCodeCreateModalLabel"><i class="ri-add-line me-1"></i> Add Invite Code</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('business.invite-codes.store') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label fw-semibold">Expires At (optional)</label>
            <input type="datetime-local" name="expires_at" class="form-control rounded-pill" value="{{ now()->format('Y') }}-12-31T23:59">
            <small class="text-muted">Default: End of this year</small>
          </div>
          <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
            <button class="btn btn-primary rounded-pill px-4"><i class="ri-save-3-line me-1"></i> Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.copy-invite-code').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const code = this.getAttribute('data-code');
            navigator.clipboard.writeText(code);
            this.classList.add('btn-success');
            this.classList.remove('btn-outline-primary');
            this.innerHTML = '<i class="ri-check-line"></i>';
            setTimeout(() => {
                this.classList.remove('btn-success');
                this.classList.add('btn-outline-primary');
                this.innerHTML = '<i class="ri-file-copy-line"></i>';
            }, 1200);
        });
    });
});
</script>
@endpush
