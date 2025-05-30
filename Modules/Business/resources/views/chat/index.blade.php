@extends('layouts.master')
@section('title', 'Chat')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="list-group" id="user-list">
            @foreach($users as $user)
                <a href="#" class="list-group-item list-group-item-action user-item d-flex align-items-center justify-content-between" data-id="{{ $user->id }}">
                    <div class="d-flex align-items-center">
                        <img src="{{ $user->profile_photo_url ?? asset('assets/images/default-avatar.png') }}" alt="Profile" class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                        <div>
                            <div class="fw-bold">{{ $user->name }}</div>
                            <div class="text-muted small">{{ $user->email }}</div>
                        </div>
                    </div>
                    <span class="badge rounded-pill {{ $user->is_online ? 'bg-success' : 'bg-secondary' }} ms-2" style="min-width: 60px;">{{ $user->is_online ? 'Active' : 'Offline' }}</span>
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Chat</div>
            <div class="card-body" id="chat-messages" style="height: 400px; overflow-y: auto;">
                {{-- Messages will be dynamically loaded here --}}
            </div>
            <div class="card-footer">
                <form id="chat-form" autocomplete="off">
                    <div class="input-group">
                        <input type="text" class="form-control" id="chat-input" placeholder="Type a message...">
                        <button class="btn btn-primary" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="auth-user-id" value="{{ auth()->id() }}">
@endsection
@section('script')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="{{ asset('js/pages/chat.init.js') }}"></script>
@endsection
