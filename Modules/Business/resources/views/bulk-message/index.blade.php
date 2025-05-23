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
                        <div class="mb-3" id="email-customize-section" style="display:none;">
                            <label for="email_subject" class="form-label fw-semibold">{{ __('Email Subject') }}</label>
                            <input type="text" name="email_subject" id="email_subject" class="form-control mb-2" placeholder="{{ __('Subject') }}">
                            <label for="email_image" class="form-label fw-semibold">{{ __('Header Image (optional)') }}</label>
                            <input type="file" name="email_image" id="email_image" class="form-control mb-2" accept="image/*">
                            <div class="form-text mb-2">{{ __('You can upload a header/banner image for your email.') }}</div>
                            <label for="email_body" class="form-label fw-semibold">{{ __('Email Body') }}</label>
                            <textarea name="email_body" id="email_body" class="form-control mb-2" rows="8" placeholder="{{ __('Write your email content here...') }}"></textarea>
                            <div class="form-text mb-2">{{ __('You can use HTML for formatting. Use <b>, <i>, <u>, <h1>-<h6>, <p>, <ul>, <ol>, <li>, <img>, <a>, etc. for rich content.') }}</div>
                            <div class="mb-2">
                                <label class="form-label fw-semibold">{{ __('Quick Style') }}</label>
                                <div class="btn-group mb-2" role="group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<b></b>')"><b>B</b></button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<i></i>')"><i>I</i></button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<u></u>')"><u>U</u></button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<h2></h2>')">H2</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<p></p>')">P</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<ul><li></li></ul>')">UL</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<ol><li></li></ol>')">OL</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<a href=\"\"></a>')">Link</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<img src=\"\" alt=\"\">')">Img</button>
                                </div>
                            </div>
                            <div class="form-text">{{ __('The message field will be ignored for email if this is filled.') }}</div>
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

        const typeSelect = document.getElementById('type');
        const emailCustomizeSection = document.getElementById('email-customize-section');
        typeSelect.addEventListener('change', function() {
            if (this.value === 'email') {
                emailCustomizeSection.style.display = '';
            } else {
                emailCustomizeSection.style.display = 'none';
            }
        });
    });

    function insertAtCursor(fieldId, value) {
        var field = document.getElementById(fieldId);
        if (!field) return;
        var start = field.selectionStart, end = field.selectionEnd;
        var before = field.value.substring(0, start), after = field.value.substring(end, field.value.length);
        field.value = before + value + after;
        field.selectionStart = field.selectionEnd = start + value.length;
        field.focus();
    }
</script>
@endsection
