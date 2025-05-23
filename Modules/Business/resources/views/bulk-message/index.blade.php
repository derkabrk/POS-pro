@extends('business::layouts.master')

@section('title')
    {{ __('Bulk Messaging') }}
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ __('Bulk Messaging') }}</h4>
                </div>
                <div class="card-body">
                    @if(session('results'))
                        <div class="alert alert-info">
                            <ul class="mb-0">
                                @foreach(session('results') as $result)
                                    <li>
                                        {{ $result['recipient'] }}: {{ $result['status'] }}
                                        @if(isset($result['error']))<span class="text-danger">({{ $result['error'] }})</span>@endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('business.bulk-message.send') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold">{{ __('Message Type') }}</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="email">Email</option>
                                <option value="sms">SMS</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="viber">Viber</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">{{ __('Select Users') }}</label>
                            <div class="list-group">
                                @php
                                    $users = \App\Models\User::whereNotNull('email')->orWhereNotNull('phone')->get();
                                @endphp
                                @foreach($users as $user)
                                    <label class="list-group-item d-flex align-items-center gap-3">
                                        <input type="checkbox" class="form-check-input user-recipient-checkbox" value="{{ $user->email ?? $user->phone }}" data-email="{{ $user->email }}" data-phone="{{ $user->phone }}" data-name="{{ $user->name }}">
                                        <img src="{{ $user->image ? asset($user->image) : asset('assets/images/default-avatar.png') }}" alt="{{ $user->name }}" class="rounded-circle" width="40" height="40">
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $user->name }}</div>
                                            <div class="small text-muted">{{ $user->email }}</div>
                                            <div class="small text-muted">{{ $user->phone }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="recipients" class="form-label fw-semibold">{{ __('Recipients (comma separated)') }}</label>
                            <input type="text" name="recipients" id="recipients" class="form-control" placeholder="example@email.com, +123456789, ..." required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold">{{ __('Message') }}</label>
                            <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('Send Bulk Message') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // When user checkboxes are selected, fill the recipients field
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.user-recipient-checkbox');
        const recipientsInput = document.getElementById('recipients');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const selected = Array.from(checkboxes).filter(c => c.checked).map(c => c.value);
                recipientsInput.value = selected.join(', ');
            });
        });
    });
</script>
@endsection
