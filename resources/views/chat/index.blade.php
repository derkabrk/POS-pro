@extends('layouts.master')
@section('title') @lang('translation.chat') @endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('build/libs/glightbox/css/glightbox.min.css')}}">
@endsection
@section('content')

<div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
    <div class="chat-leftsidebar border bg-transparent">
        <div class="px-4 pt-4 mb-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1">
                    <h5 class="mb-4">Chats</h5>
                </div>
                <div class="flex-shrink-0">
                    <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="Add Contact">
                        <button type="button" class="btn btn-soft-success btn-sm">
                            <i class="ri-add-line align-bottom"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="search-box">
                <input type="text" class="form-control bg-light border-light" placeholder="Search here...">
                <i class="ri-search-2-line search-icon"></i>
            </div>
        </div> <!-- .p-4 -->

        <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#chats" role="tab">
                    Chats
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#contacts" role="tab">
                    Contacts
                </a>
            </li>
        </ul>

        <div class="tab-content text-muted">
            <div class="tab-pane active" id="chats" role="tabpanel">
                <div class="chat-room-list pt-3" data-simplebar>
                    <div class="d-flex align-items-center px-4 mb-2">
                        <div class="flex-grow-1">
                            <h4 class="mb-0 fs-11 text-muted text-uppercase">Direct Messages</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="New Message">
                                <button type="button" class="btn btn-soft-success btn-sm shadow-none">
                                    <i class="ri-add-line align-bottom"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="chat-message-list">
                        <ul class="list-unstyled chat-list chat-user-list" id="user-list">
                            @foreach($users as $user)
                                <li class="user-item d-flex align-items-center py-2 px-3 mb-1 rounded {{ $user->is_online ? 'bg-light' : '' }}" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-avatar="{{ $user->profile_photo_url && filter_var($user->profile_photo_url, FILTER_VALIDATE_URL) ? $user->profile_photo_url : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff' }}" data-status="{{ $user->is_online ? 'Online' : 'Offline' }}">
                                    <div class="flex-shrink-0 position-relative me-3">
                                        <img src="{{ $user->profile_photo_url && filter_var($user->profile_photo_url, FILTER_VALIDATE_URL) ? $user->profile_photo_url : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff' }}" class="rounded-circle avatar-md border border-2 {{ $user->is_online ? 'border-success' : 'border-secondary' }}" alt="">
                                        <span class="position-absolute bottom-0 end-0 translate-middle p-1 bg-{{ $user->is_online ? 'success' : 'secondary' }} border border-light rounded-circle"></span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="mb-0 text-truncate fs-15">{{ $user->name }}</h6>
                                            <span class="badge bg-{{ $user->is_online ? 'success' : 'secondary' }}-subtle text-{{ $user->is_online ? 'success' : 'secondary' }} fs-11">{{ $user->is_online ? 'Online' : 'Offline' }}</span>
                                        </div>
                                        <div class="text-muted fs-12 text-truncate">{{ $user->email }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="contacts" role="tabpanel">
                <div class="chat-room-list pt-3" data-simplebar>
                    <div class="sort-contact">
                        <!-- Contacts content can be added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end chat leftsidebar -->

    <!-- Start User chat -->
    <div class="user-chat w-100 overflow-hidden">
        <div class="chat-content d-lg-flex">
            <!-- start chat conversation section -->
            <div class="w-100 overflow-hidden position-relative">
                <!-- conversation user -->
                <div class="position-relative">
                    <div class="position-relative" id="users-chat">
                        <div class="p-3 user-chat-topbar bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-sm-4 col-8">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 d-block d-lg-none me-3">
                                            <a href="javascript: void(0);" class="user-chat-remove fs-18 p-1">
                                                <i class="ri-arrow-left-s-line align-bottom"></i>
                                            </a>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0" id="selected-user-avatar">
                                                    <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" class="rounded-circle avatar-xs" alt="" id="selected-user-img">
                                                    <span class="user-status"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate mb-0 fs-16">
                                                        <a class="text-reset username" id="selected-user-name">Select a user to chat</a>
                                                    </h5>
                                                    <p class="text-truncate text-muted fs-14 mb-0 userStatus">
                                                        <small id="selected-user-status">Choose someone to start chatting</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end chat user head -->

                        <div class="chat-conversation p-3 p-lg-4" id="chat-messages" data-simplebar style="height: 400px;">
                            <div id="elmLoader">
                                <div class="spinner-border text-primary avatar-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <ul class="list-unstyled chat-conversation-list" id="users-conversation">
                                <!-- Messages will be dynamically loaded here -->
                            </ul>
                        </div>

                        <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show" id="copyClipBoard" role="alert" style="display: none;">
                            Message copied
                        </div>
                    </div>
                </div>

                <!-- Chat Input Section -->
                <div class="chat-input-section p-3 p-lg-4 bg-transparent">
                    <form id="chat-form" enctype="multipart/form-data" autocomplete="off">
                        <div class="row g-0 align-items-center">
                            <div class="col-auto">
                                <div class="chat-input-links me-2">
                                    <div class="links-list-item">
                                        <button type="button" class="btn btn-link text-decoration-none emoji-btn" id="emoji-btn">
                                            <i class="bx bx-smile align-middle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="chat-input-feedback">
                                    Please Enter a Message
                                </div>
                                <input type="text" class="form-control chat-input bg-light border-light" id="chat-input" placeholder="Type your message..." autocomplete="off">
                            </div>

                            <div class="col-auto">
                                <div class="chat-input-links ms-2">
                                    <div class="links-list-item">
                                        <button type="submit" class="btn btn-success chat-send waves-effect waves-light">
                                            <i class="ri-send-plane-2-fill align-bottom"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="replyCard" style="display: none;">
                    <div class="card mb-0">
                        <div class="card-body py-3">
                            <div class="replymessage-block mb-0 d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <h5 class="conversation-name"></h5>
                                    <p class="mb-0"></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" id="close_toggle" class="btn btn-sm btn-link mt-n2 me-n3 fs-18">
                                        <i class="bx bx-x align-middle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end chat-wrapper -->

<input type="hidden" id="auth-user-id" value="{{ auth()->id() }}">

@endsection

@section('script')
<script src="{{ URL::asset('build/libs/glightbox/js/glightbox.min.js') }}"></script>
<!-- fgEmojiPicker js -->
<script src="{{ URL::asset('build/libs/fg-emoji-picker/fgEmojiPicker.js') }}"></script>
<!-- Pusher -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<!-- chat init js -->
<script src="{{ URL::asset('build/js/pages/chat.init.js') }}"></script>
<script src="{{ asset('js/pages/chat.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>

<script>
$(function() {
    let selectedUserId = null;
    let selectedUserData = {};

    // Initial state: hide chat input and conversation until user is selected
    $('.chat-input-section').hide();
    $('#users-conversation').hide();
    $('#elmLoader').hide();

    // Remove welcome message until a user is selected
    $('#users-conversation').empty();

    // User selection logic
    $(document).on('click', '.user-item', function(e) {
        e.preventDefault();
        // Remove active class from all users
        $('.user-item').removeClass('active');
        // Add active class to selected user
        $(this).addClass('active');
        // Get user data from data attributes
        selectedUserId = $(this).data('id');
        selectedUserData = {
            id: $(this).data('id'),
            name: $(this).data('name'),
            email: $(this).data('email'),
            avatar: $(this).data('avatar'),
            status: $(this).data('status'),
            isOnline: $(this).data('status') === 'Online'
        };
        // Update chat header with selected user info
        $('#selected-user-name').text(selectedUserData.name);
        $('#selected-user-status').text(selectedUserData.status + ' | ' + selectedUserData.email);
        $('#selected-user-img').attr('src', selectedUserData.avatar);
        $('#selected-user-avatar')
            .removeClass('online away')
            .addClass(selectedUserData.isOnline ? 'online' : 'away');
        // Show chat interface and hide loader
        $('#elmLoader').hide();
        $('#users-conversation').show();
        $('.chat-input-section').show();
        // Clear previous messages
        $('#users-conversation').empty();
        // Load chat messages for selected user (AJAX)
        loadChatMessages(selectedUserId);
    });

    // Enable pointer and hover for user list
    $('#user-list').css('cursor', 'pointer');
    $(document).on('mouseenter', '.user-item', function() {
        $(this).addClass('bg-primary-subtle');
    }).on('mouseleave', '.user-item', function() {
        $(this).removeClass('bg-primary-subtle');
    });

    // Form submission logic
    $('#chat-form').on('submit', function(e) {
        e.preventDefault();
        const message = $('#chat-input').val().trim();
        if (!message || !selectedUserId) {
            if (!selectedUserId) {
                $('.chat-input-feedback').text('Please select a user to chat with').show();
                setTimeout(() => $('.chat-input-feedback').hide(), 3000);
            }
            return;
        }
        $('.chat-input-feedback').hide();
        $('.chat-send').prop('disabled', true);
        $.post('/chat/send', {
            recipient_id: selectedUserId,
            message: message,
            _token: '{{ csrf_token() }}'
        })
        .done(function(response) {
            $('#chat-input').val('');
            const messageData = {
                content: message,
                sender_id: {{ auth()->id() }},
                sender_name: '{{ auth()->user()->name }}',
                sender_avatar: '{{ auth()->user()->profile_photo_url ?? "https://ui-avatars.com/api/?name=" . urlencode(auth()->user()->name) . "&background=0D8ABC&color=fff" }}',
                created_at: new Date().toISOString()
            };
            appendMessage(messageData, true);
            $('#users-conversation .text-center').closest('li').remove();
        })
        .fail(function(xhr) {
            $('.chat-input-feedback').text('Failed to send message. Please try again.').show();
            setTimeout(() => $('.chat-input-feedback').hide(), 3000);
        })
        .always(function() {
            $('.chat-send').prop('disabled', false);
        });
    });

    // Function to load chat messages
    function loadChatMessages(userId) {
        $.get('/chat/messages/' + userId)
        .done(function(messages) {
            $('#users-conversation').empty();
            if (messages && messages.length > 0) {
                messages.forEach(function(message) {
                    appendMessage(message, message.sender_id == {{ auth()->id() }});
                });
            } else {
                const welcomeMessage = `
                    <li class="chat-list left">
                        <div class="conversation-list">
                            <div class="user-chat-content">
                                <div class="ctext-wrap">
                                    <div class="ctext-wrap-content text-center">
                                        <p class="mb-0 text-muted">Start your conversation with ${selectedUserData.name}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                `;
                $('#users-conversation').append(welcomeMessage);
            }
            scrollToBottom();
        })
        .fail(function() {
            $('#users-conversation').html(`
                <li class="chat-list">
                    <div class="conversation-list">
                        <div class="user-chat-content">
                            <div class="ctext-wrap">
                                <div class="ctext-wrap-content text-center">
                                    <p class="mb-0 text-danger">Failed to load messages</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            `);
        });
    }

    // Function to append message to chat
    function appendMessage(message, isSent) {
        const messageClass = isSent ? 'right' : 'left';
        const messageHtml = `
            <li class="chat-list ${messageClass}">
                <div class="conversation-list">
                    <div class="chat-avatar">
                        <img src="${message.sender_avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(message.sender_name || 'User') + '&background=0D8ABC&color=fff'}" alt="" class="rounded-circle avatar-xs">
                    </div>
                    <div class="user-chat-content">
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content">
                                <p class="mb-0 ctext-content">${escapeHtml(message.content)}</p>
                            </div>
                        </div>
                        <div class="conversation-name">
                            <small class="text-muted time">${formatTime(message.created_at)}</small>
                            ${isSent ? '<span class="text-success check-message-icon"><i class="ri-check-double-line align-bottom"></i></span>' : ''}
                        </div>
                    </div>
                </div>
            </li>
        `;
        $('#users-conversation').append(messageHtml);
        scrollToBottom();
    }

    // Function to scroll to bottom
    function scrollToBottom() {
        const chatContainer = $('#chat-messages');
        chatContainer.scrollTop(chatContainer[0].scrollHeight);
    }

    // Function to escape HTML
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Copy message functionality
    $(document).on('click', '.copy-message', function(e) {
        e.preventDefault();
        const messageText = $(this).closest('.ctext-wrap').find('.ctext-content').text();
        navigator.clipboard.writeText(messageText).then(function() {
            $('#copyClipBoard').fadeIn().delay(2000).fadeOut();
        });
    });

    // Initial state: hide chat input and conversation until user is selected
    $('.chat-input-section').hide();
    $('#users-conversation').hide();
    $('#elmLoader').hide();
    // Show instructions when no user is selected
    $('#users-conversation').html(`
        <li class="chat-list">
            <div class="conversation-list">
                <div class="user-chat-content">
                    <div class="ctext-wrap">
                        <div class="ctext-wrap-content text-center">
                            <div class="avatar-lg mx-auto mb-3">
                                <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                    <i class="ri-message-3-line display-4"></i>
                                </div>
                            </div>
                            <h5 class="mb-2">Welcome to Chat!</h5>
                            <p class="text-muted mb-0">Select a user from the sidebar to start chatting</p>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    `);
});
</script>
@endsection