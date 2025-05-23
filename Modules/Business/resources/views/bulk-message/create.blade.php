@extends('business::layouts.master')

@section('title')
    {{ __('Bulk Messaging') }}
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="min-height: 80vh;">
                <div class="card-header bg-gradient-primary text-white d-flex align-items-center justify-content-between" style="padding: 2rem 2rem 1rem 2rem;">
                    <h4 class="mb-0"><i class="fas fa-broadcast-tower me-2"></i> {{ __('Bulk Messaging') }}</h4>
                    <span class="badge bg-light text-primary px-3 py-2 fs-6">{{ date('M d, Y') }}</span>
                </div>
                <div class="card-body" style="padding: 2rem;">
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
                    <form method="POST" action="{{ route('business.bulk-message.send') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6 border-end">
                                <div class="mb-4" id="email-customize-section" style="display:none;">
                                    <label for="email_subject" class="form-label fw-bold fs-5">{{ __('Email Subject') }}</label>
                                    <input type="text" name="email_subject" id="email_subject" class="form-control form-control-xl mb-3 py-3 fs-5" placeholder="{{ __('Subject') }}">
                                    <label for="email_image" class="form-label fw-bold fs-5">{{ __('Header Image (optional)') }}</label>
                                    <input type="file" name="email_image" id="email_image" class="form-control mb-3 py-2 fs-6" accept="image/*">
                                    <div class="form-text mb-3 fs-6">{{ __('You can upload a header/banner image for your email.') }}</div>
                                    <label for="email_body" class="form-label fw-bold fs-5">{{ __('Email Body') }}</label>
                                    <textarea name="email_body" id="email_body" class="form-control mb-3 py-3 fs-5" rows="8" placeholder="{{ __('Write your email content here...') }}"></textarea>
                                    <div class="form-text mb-3 fs-6">{{ __('You can use HTML for formatting. Use <b>, <i>, <u>, <h1>-<h6>, <p>, <ul>, <ol>, <li>, <img>, <a>, etc. for rich content.') }}</div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold fs-6">{{ __('Quick Style') }}</label>
                                        <div class="btn-group mb-2" role="group">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<b></b>')"><b>B</b></button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<i></i>')"><i>I</i></button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<u></u>')"><u>U</u></button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<h2></h2>')">H2</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<p></p>')">P</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<ul><li></li></ul>')">UL</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<ol><li></li></ol>')">OL</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<a href=\"\"></a>')">Link</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertAtCursor('email_body', '<img src=\"\" alt="">')">Img</button>
                                        </div>
                                    </div>
                                    <div class="form-text fs-6">{{ __('The message field will be ignored for email if this is filled.') }}</div>
                                </div>
                                <div class="mb-4">
                                    <label for="message" class="form-label fw-bold fs-5">{{ __('Message') }}</label>
                                    <textarea name="message" id="message" class="form-control form-control-xl py-3 fs-5" rows="8" required placeholder="{{ __('Type your message here...') }}"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="type" class="form-label fw-bold fs-5">{{ __('Message Type') }}</label>
                                    <select name="type" id="type" class="form-select form-select-xl py-3 fs-5" required>
                                        <option value="email" selected>Email</option>
                                        <option value="sms">SMS</option>
                                        <option value="whatsapp">WhatsApp</option>
                                        <option value="viber">Viber</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold fs-5">{{ __('Select Users') }}</label>
                                    <div class="list-group list-group-flush rounded shadow-sm bg-light" style="max-height: 340px; overflow-y: auto;">
                                        @php
                                            $users = \App\Models\User::whereNotNull('email')->orWhereNotNull('phone')->get();
                                        @endphp
                                        @foreach($users as $user)
                                            <label class="list-group-item d-flex align-items-center gap-3 py-3 fs-6">
                                                <input type="checkbox" class="form-check-input user-recipient-checkbox" value="{{ $user->email ?? $user->phone }}" data-email="{{ $user->email }}" data-phone="{{ $user->phone }}" data-name="{{ $user->name }}">
                                                <img src="{{ $user->image ? asset($user->image) : asset('assets/images/default-avatar.png') }}" alt="{{ $user->name }}" class="rounded-circle border border-2" width="48" height="48">
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold text-dark fs-6">{{ $user->name }}</div>
                                                    <div class="small text-muted">{{ $user->email }}</div>
                                                    <div class="small text-muted">{{ $user->phone }}</div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="recipients" class="form-label fw-bold fs-5">{{ __('Recipients (comma separated)') }}</label>
                                    <input type="text" name="recipients" id="recipients" class="form-control form-control-xl py-3 fs-5" placeholder="example@email.com, +123456789, ..." required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg w-100 shadow mt-4 py-3 fs-5">{{ __('Send Bulk Message') }}</button>
                            </div>
                        </div>
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
                const selected = Array.from(checkboxes)
                    .filter(c => c.checked)
                    .map(c => c.value)
                    .filter(v => v && /.+@.+\..+/.test(v)); // Only include valid-looking emails
                recipientsInput.value = selected.join(', ');
            });
        });

        const typeSelect = document.getElementById('type');
        const emailCustomizeSection = document.getElementById('email-customize-section');
        // Show email customization by default
        emailCustomizeSection.style.display = '';
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
