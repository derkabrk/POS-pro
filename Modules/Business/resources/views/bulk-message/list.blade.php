@extends('business::layouts.master')

@section('title')
    {{ __('Sent Bulk Messages') }}
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><i class="bi bi-envelope-paper-fill me-2"></i> {{ __('Sent Bulk Messages') }}</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Subject/Content') }}</th>
                                    <th>{{ __('Recipients') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Sent At') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($messages as $msg)
                                    <tr>
                                        <td>{{ $msg->id }}</td>
                                        <td><span class="badge bg-info text-dark text-uppercase">{{ $msg->type }}</span></td>
                                        <td>
                                            @if($msg->type === 'email')
                                                <div class="fw-bold">{{ $msg->subject }}</div>
                                                <div class="small text-muted">{!! Str::limit(strip_tags($msg->content), 60) !!}</div>
                                            @else
                                                <div class="small text-muted">{!! Str::limit(strip_tags($msg->content), 60) !!}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="small">{{ Str::limit($msg->recipients, 40) }}</span>
                                        </td>
                                        <td>
                                            @if(is_array($msg->results))
                                                @php $sent = collect($msg->results)->where('status', 'sent')->count(); @endphp
                                                <span class="badge bg-success">{{ $sent }} {{ __('sent') }}</span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $msg->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">{{ __('No sent messages found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
