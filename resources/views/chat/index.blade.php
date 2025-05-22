@extends('layouts.master')
@section('title') @lang('translation.chat') @endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('build/libs/glightbox/css/glightbox.min.css')}}">
<style>
.user-item {
    cursor: pointer;
    transition: all 0.2s ease;
    border-radius: 8px;
}
.user-item:hover {
    background-color: rgba(13, 138, 188, 0.1) !important;
    transform: translateX(2px);
}
.user-item.active {
    background-color: rgba(13, 138, 188, 0.15) !important;
    border-left: 3px solid #0d8abc;
}
.chat-input-feedback {
    display: none;
    color: #dc3545;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}
.chat-conversation {
    max-height: 500px;
    overflow-y: auto;
}
.online-indicator {
    width: 8px;
    height: 8px;
    background-color: #28a745;
    border-radius: 50%;
    position: absolute;
    bottom: 2px;
    right: 2px;
    border: 2px solid white;
}
.offline-indicator {
    width: 8px;
    height: 8px;
    background-color: #6c757d;
    border-radius: 50%;
    position: absolute;
    bottom: 2px;
    right: 2px;
    border: 2px solid white;
}
/* Enhanced chat message bubbles */
.ctext-wrap-content {
    background: linear-gradient(135deg, #e9f3fa 0%, #f5f7fa 100%);
    border-radius: 18px 18px 18px 4px;
    padding: 14px 22px;
    box-shadow: 0 2px 12px rgba(13,138,188,0.10);
    font-size: 15px;
    color: #222;
    position: relative;
    max-width: 420px;
    word-break: break-word;
    transition: background 0.2s;
    border: 1px solid #e0eafc;
}
.chat-list.right .ctext-wrap-content {
    background: linear-gradient(135deg, #0d8abc 0%, #0b7ab0 100%);
    color: #fff;
    border-radius: 18px 18px 4px 18px;
    border: 1px solid #0d8abc;
}
.ctext-wrap-content:hover {
    background: #d6eaff;
}
.chat-list.right .ctext-wrap-content:hover {
    background: #0b7ab0;
}
.ctext-wrap-content .dropdown {
    position: absolute;
    top: 8px;
    right: 12px;
}
.ctext-content {
    margin-bottom: 0;
    white-space: pre-line;
    font-size: 15px;
    line-height: 1.7;
}
.conversation-name {
    margin-top: 6px;
    font-size: 12px;
    color: #8a99b5;
    display: flex;
    align-items: center;
    gap: 6px;
}
.check-message-icon {
    font-size: 13px;
    margin-left: 2px;
}
.chat-avatar img {
    border: 2px solid #fff;
    box-shadow: 0 2px 8px rgba(13,138,188,0.13);
}
@media (max-width: 600px) {
    .ctext-wrap-content {
        max-width: 90vw;
        padding: 10px 12px;
    }
}
.chat-bubble-sent {
    background: linear-gradient(135deg, #0d8abc 0%, #0b7ab0 100%) !important;
    color: #fff !important;
    box-shadow: 0 2px 12px rgba(13,138,188,0.13);
    border-radius: 18px 18px 4px 18px !important;
    border: 1px solid #0d8abc !important;
}
.chat-bubble-received {
    background: linear-gradient(135deg, #e9f3fa 0%, #f5f7fa 100%) !important;
    color: #222 !important;
    box-shadow: 0 2px 12px rgba(13,138,188,0.10);
    border-radius: 18px 18px 18px 4px !important;
    border: 1px solid #e0eafc !important;
}
</style>
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
                <input type="text" class="form-control bg-light border-light" placeholder="Search here..." id="user-search">
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
                            @php
                                // Only show users with at least one chat (latest_message exists)
                                $chatedUsers = isset($users) ? collect($users)->filter(function($user) {
                                    return isset($user->latest_message) && $user->latest_message;
                                })->sortByDesc(function($user) {
                                    return optional($user->latest_message)->created_at;
                                })->values() : collect();
                            @endphp
                            @if($chatedUsers->count() > 0)
                                @foreach($chatedUsers as $user)
                                    <li class="user-item p-3 mb-2"
                                        data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->name }}"
                                        data-user-email="{{ $user->email }}"
                                        data-user-avatar="{{ $user->profile_photo_url && filter_var($user->profile_photo_url, FILTER_VALIDATE_URL) ? $user->profile_photo_url : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff' }}"
                                        data-user-status="{{ $user->is_online ? 'Online' : 'Offline' }}"
                                        data-is-online="{{ $user->is_online ? '1' : '0' }}"
                                        style="cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 position-relative me-3">
                                                <img src="{{ $user->profile_photo_url && filter_var($user->profile_photo_url, FILTER_VALIDATE_URL) ? $user->profile_photo_url : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff' }}"
                                                     class="rounded-circle avatar-sm"
                                                     alt="{{ $user->name }}"
                                                     style="pointer-events: none;">
                                                <span class="{{ $user->is_online ? 'online-indicator' : 'offline-indicator' }}" style="pointer-events: none;"></span>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden" style="pointer-events: none;">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h6 class="mb-0 text-truncate fs-14 fw-medium">{{ $user->name }}</h6>
                                                    <span class="badge bg-{{ $user->is_online ? 'success' : 'secondary' }}-subtle text-{{ $user->is_online ? 'success' : 'secondary' }} fs-11">
                                                        {{ $user->is_online ? 'Online' : 'Offline' }}
                                                    </span>
                                                </div>
                                                <div class="text-truncate small mt-1" style="max-width: 90%;">
                                                    @if($user->latest_message->sender_id == auth()->id())
                                                        <span class="fw-semibold text-white">You: </span>
                                                        <span class="text-white">{{ \Illuminate\Support\Str::limit($user->latest_message->content ?? $user->latest_message->message, 40) }}</span>
                                                    @else
                                                        <span class="fw-bold text-white">{{ \Illuminate\Support\Str::limit($user->latest_message->content ?? $user->latest_message->message, 40) }}</span>
                                                    @endif
                                                    <span class="text-muted ms-1 fs-11">{{ $user->latest_message->created_at ? $user->latest_message->created_at->diffForHumans() : '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-center py-4">
                                    <p class="text-muted">No users with chat history</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="contacts" role="tabpanel">
                <div class="chat-room-list pt-3" data-simplebar>
                    <div class="sort-contact">
                        <!-- Contacts content can be added here -->
                        <div class="text-center py-4">
                            <p class="text-muted">Contacts feature coming soon</p>
                        </div>
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
                        <div class="p-3 user-chat-topbar">
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
                                                <div class="flex-shrink-0 position-relative me-3" id="selected-user-avatar-container">
                                                    <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" 
                                                         class="rounded-circle avatar-sm" 
                                                         alt="" 
                                                         id="selected-user-img">
                                                    <span class="user-status-indicator" id="selected-user-status-dot"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate mb-0 fs-16">
                                                        <span class="text-reset username" id="selected-user-name">Select a user to chat</span>
                                                    </h5>
                                                    <p class="text-truncate text-muted fs-14 mb-0">
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

                        <div class="chat-conversation p-3 p-lg-4" id="chat-messages" data-simplebar style="min-height: 400px; max-height: 500px;">
                            <div id="elmLoader" style="display: none;">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border text-primary avatar-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-unstyled chat-conversation-list" id="users-conversation">
                                <!-- Default welcome message -->
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
                            </ul>
                        </div>

                        <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show" id="copyClipBoard" role="alert" style="display: none;">
                            Message copied
                        </div>
                    </div>
                </div>

                <!-- Chat Input Section -->
                <div class="chat-input-section p-3 p-lg-4" id="chat-input-container" style="display: none;">
                    <form id="chat-form" autocomplete="off">
                        @csrf
                        <div class="chat-input-feedback" id="chat-feedback"></div>
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
                                <input type="hidden" id="recipient-id" name="recipient_id" value="">
                                <input type="text" 
                                       class="form-control chat-input bg-light border-light" 
                                       id="chat-input" 
                                       name="message"
                                       placeholder="Type your message..." 
                                       autocomplete="off"
                                       maxlength="1000">
                            </div>

                            <div class="col-auto">
                                <div class="chat-input-links ms-2">
                                    <div class="links-list-item">
                                        <button type="submit" class="btn btn-success chat-send waves-effect waves-light" id="send-btn">
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
<input type="hidden" id="csrf-token" value="{{ csrf_token() }}">

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
  window.PUSHER_APP_KEY = "{{ env('PUSHER_APP_KEY') }}";
  window.PUSHER_APP_CLUSTER = "{{ env('PUSHER_APP_CLUSTER') }}";
</script>

<script>
$(document).ready(function() {
    // Global variables
    let selectedUserId = null;
    let selectedUserData = {};
    let isLoading = false;
    let messagesPage = 1;
    let messagesLastPage = false;
    let isMessagesLoading = false;
    let messagesLoadedIds = new Set();
    
    // Initialize chat state
    initializeChat();
    
    // Debug: Add click test
    console.log('Chat script loaded. Testing user list...');
    
    // Test if users exist in DOM
    setTimeout(function() {
        const userCount = $('.user-item').length;
        console.log(`Found ${userCount} users in the list`);
        
        if (userCount === 0) {
            console.warn('No users found! Check if $users variable is populated in your controller.');
        } else {
            $('.user-item').each(function(index) {
                const userId = $(this).data('user-id') || $(this).attr('data-user-id');
                const userName = $(this).data('user-name') || $(this).attr('data-user-name');
                console.log(`User ${index + 1}: ID=${userId}, Name=${userName}`);
            });
        }
        
        // Test click handler
        $('.user-item').first().css('border', '2px solid red');
        console.log('First user highlighted in red for testing');
    }, 1000);
    
    function initializeChat() {
        // Hide chat input initially
        $('#chat-input-container').hide();
        
        // Setup event listeners
        setupEventListeners();
        
        // Setup user search
        setupUserSearch();
        
        console.log('Chat initialized');
    }
    
    function setupEventListeners() {
        // User selection click handler - use more specific selector and event delegation
        $(document).off('click.userSelection').on('click.userSelection', '.user-item', handleUserSelection);
        
        // Also handle click on user item children
        $(document).off('click.userSelectionChild').on('click.userSelectionChild', '.user-item *', function(e) {
            e.stopPropagation();
            $(this).closest('.user-item').trigger('click');
        });
        
        // Form submission handler
        $('#chat-form').off('submit.chatForm').on('submit.chatForm', handleMessageSubmit);
        
        // Enter key handler for chat input
        $('#chat-input').off('keypress.chatInput').on('keypress.chatInput', function(e) {
            if (e.which === 13 && !e.shiftKey) {
                e.preventDefault();
                $('#chat-form').submit();
            }
        });
        
        // Copy message functionality
        $(document).off('click.copyMessage').on('click.copyMessage', '.copy-message', handleCopyMessage);
        
        // Real-time input validation
        $('#chat-input').off('input.validation').on('input.validation', function() {
            const message = $(this).val().trim();
            if (message.length > 0) {
                hideFeedback();
            }
        });
        
        // Infinite scroll event
        $('#chat-messages').off('scroll.infinite').on('scroll.infinite', function() {
            if ($(this).scrollTop() === 0 && !isMessagesLoading && !messagesLastPage) {
                loadChatMessages(selectedUserId, true);
            }
        });
        
        console.log('Event listeners setup completed');
    }
    
    function setupUserSearch() {
        $('#user-search').on('input', function() {
            const searchTerm = $(this).val().toLowerCase().trim();
            if (searchTerm.length === 0) {
                // If search is empty, reload only chated users
                $('.user-item').show();
                return;
            }
            // AJAX search in users table
            $.ajax({
                url: '/chat/search-users',
                method: 'GET',
                data: { q: searchTerm },
                success: function(users) {
                    // Remove all user items
                    $('#user-list').empty();
                    if (users.length === 0) {
                        $('#user-list').append('<li class="text-center py-4"><p class="text-muted">No users found</p></li>');
                        return;
                    }
                    users.forEach(function(user) {
                        // Defensive: fallback for missing fields
                        const name = user.name || 'Unknown';
                        const email = user.email || '';
                        let avatar = '';
                        if (user.profile_photo_url && typeof user.profile_photo_url === 'string' && user.profile_photo_url.match(/^https?:\/\//)) {
                            avatar = user.profile_photo_url;
                        } else {
                            avatar = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(name) + '&background=0D8ABC&color=fff';
                        }
                        const isOnline = user.is_online ? 'Online' : 'Offline';
                        const badgeClass = user.is_online ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary';
                        const latestMsg = user.latest_message;
                        let latestMsgHtml = '';
                        if (latestMsg) {
                            if (latestMsg.sender_id == $('#auth-user-id').val()) {
                                latestMsgHtml = '<span class="fw-semibold text-white">You: </span>' +
                                    '<span class="text-white">' + escapeHtml((latestMsg.content || latestMsg.message || '').substring(0, 40)) + '</span>';
                            } else {
                                latestMsgHtml = '<span class="fw-bold text-white">' + escapeHtml((latestMsg.content || latestMsg.message || '').substring(0, 40)) + '</span>';
                            }
                            latestMsgHtml += '<span class="text-muted ms-1 fs-11">' + (latestMsg.created_at_human || '') + '</span>';
                        } else {
                            latestMsgHtml = '<span class="text-muted">No messages yet</span>';
                        }
                        $('#user-list').append(`
                            <li class="user-item p-3 mb-2"
                                data-user-id="${user.id}"
                                data-user-name="${name}"
                                data-user-email="${email}"
                                data-user-avatar="${avatar}"
                                data-user-status="${isOnline}"
                                data-is-online="${user.is_online ? '1' : '0'}"
                                style="cursor: pointer;">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 position-relative me-3">
                                        <img src="${avatar}"
                                             class="rounded-circle avatar-sm"
                                             alt="${name}"
                                             style="pointer-events: none;">
                                        <span class="${user.is_online ? 'online-indicator' : 'offline-indicator'}" style="pointer-events: none;"></span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden" style="pointer-events: none;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="mb-0 text-truncate fs-14 fw-medium">${name}</h6>
                                            <span class="badge ${badgeClass} fs-11">${isOnline}</span>
                                        </div>
                                        <div class="text-truncate small mt-1" style="max-width: 90%;">
                                            ${latestMsgHtml}
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `);
                    });
                },
                error: function() {
                    $('#user-list').empty().append('<li class="text-center py-4"><p class="text-muted">Search failed</p></li>');
                }
            });
        });
    }
    
    function handleUserSelection(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (isLoading) return;
        
        const $clickedUser = $(this);
        
        console.log('User clicked:', $clickedUser);
        
        // Remove active class from all users
        $('.user-item').removeClass('active');
        
        // Add active class to selected user
        $clickedUser.addClass('active');
        
        // Get user data from data attributes with fallbacks
        selectedUserId = $clickedUser.data('user-id') || $clickedUser.attr('data-user-id');
        if (!selectedUserId) {
            showFeedback('Error selecting user. Please try again.', 'error');
            return;
        }
        
        selectedUserData = {
            id: selectedUserId,
            name: $clickedUser.data('user-name') || $clickedUser.attr('data-user-name') || 'Unknown User',
            email: $clickedUser.data('user-email') || $clickedUser.attr('data-user-email') || '',
            avatar: $clickedUser.data('user-avatar') || $clickedUser.attr('data-user-avatar') || 'https://ui-avatars.com/api/?name=User&background=0D8ABC&color=fff',
            status: $clickedUser.data('user-status') || $clickedUser.attr('data-user-status') || 'Offline',
            isOnline: ($clickedUser.data('is-online') || $clickedUser.attr('data-is-online')) === 1 || ($clickedUser.data('is-online') || $clickedUser.attr('data-is-online')) === '1'
        };
        
        console.log('Selected user data:', selectedUserData);
        
        updateChatHeader();
        showChatInterface();
        loadChatMessages(selectedUserId);
    }
    
    function updateChatHeader() {
        $('#selected-user-name').text(selectedUserData.name);
        $('#selected-user-status').text(selectedUserData.status + ' • ' + selectedUserData.email);
        $('#selected-user-img').attr('src', selectedUserData.avatar);
        $('#recipient-id').val(selectedUserData.id);
        
        const statusDot = $('#selected-user-status-dot');
        statusDot.removeClass('online-indicator offline-indicator');
        statusDot.addClass(selectedUserData.isOnline ? 'online-indicator' : 'offline-indicator');
    }
    
    function showChatInterface() {
        $('#chat-input-container').show();
        $('#chat-input').focus();
    }
    
    function handleMessageSubmit(e) {
        e.preventDefault();
        
        if (isLoading) return;
        
        const message = $('#chat-input').val().trim();
        
        // Validation
        if (!message) {
            showFeedback('Please enter a message', 'error');
            return;
        }
        if (!selectedUserId) {
            showFeedback('Please select a user to chat with', 'error');
            return;
        }
        if (message.length > 1000) {
            showFeedback('Message is too long (max 1000 characters)', 'error');
            return;
        }
        
        sendMessage(message);
    }
    
    function sendMessage(message) {
        isLoading = true;
        $('#send-btn').prop('disabled', true).html('<i class="ri-loader-4-line spin"></i>');
        hideFeedback();
        
        const messageData = {
            receiver_id: selectedUserId, // changed from recipient_id to receiver_id
            message: message,
            _token: $('#csrf-token').val()
        };
        
        console.log('Sending message:', messageData);
        
        $.ajax({
            url: '/chat/send',
            method: 'POST',
            data: messageData,
            timeout: 10000
        })
        .done(function(response) {
            console.log('Message sent successfully:', response);
            
            $('#chat-input').val('');
            
            const displayMessage = {
                id: response.id || Date.now(),
                content: message,
                sender_id: parseInt($('#auth-user-id').val()),
                sender_name: '{{ auth()->user()->name }}',
                sender_avatar: '{{ auth()->user()->profile_photo_url ?? "https://ui-avatars.com/api/?name=" . urlencode(auth()->user()->name) . "&background=0D8ABC&color=fff" }}',
                created_at: new Date().toISOString(),
                is_read: false
            };
            
            removeWelcomeMessage();
            appendMessage(displayMessage, true);
            showFeedback('Message sent successfully', 'success');
            setTimeout(hideFeedback, 2000);
        })
        .fail(function(xhr, status, error) {
            console.error('Failed to send message:', xhr.responseText || error);
            let errorMessage = 'Failed to send message. Please try again.';
            
            if (xhr.status === 422) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    errorMessage = Object.values(errors).flat().join(', ');
                }
            } else if (xhr.status === 401) {
                errorMessage = 'You are not authorized. Please refresh the page.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            } else if (status === 'timeout') {
                errorMessage = 'Request timeout. Please check your connection.';
            }
            
            showFeedback(errorMessage, 'error');
        })
        .always(function() {
            isLoading = false;
            $('#send-btn').prop('disabled', false).html('<i class="ri-send-plane-2-fill align-bottom"></i>');
        });
    }
    
    function loadChatMessages(userId, append = false) {
        if (!userId || isMessagesLoading || messagesLastPage) return;
        isMessagesLoading = true;
        $('#elmLoader').show();
        if (!append) {
            $('#users-conversation').empty();
            messagesPage = 1;
            messagesLastPage = false;
            messagesLoadedIds.clear();
        }
        $.ajax({
            url: `/chat/messages/${userId}?page=${messagesPage}`,
            method: 'GET',
            timeout: 10000
        })
        .done(function(response) {
            let messages = response.data || response;
            if (Array.isArray(messages) && messages.length > 0) {
                // If paginated, reverse for prepend
                if (append) messages = messages.reverse();
                messages.forEach(function(message) {
                    if (!messagesLoadedIds.has(message.id)) {
                        const isSent = message.sender_id == parseInt($('#auth-user-id').val());
                        if (append) {
                            $('#users-conversation').prepend(appendMessageHtml(message, isSent));
                        } else {
                            appendMessage(message, isSent);
                        }
                        messagesLoadedIds.add(message.id);
                    }
                });
                messagesPage++;
                if (response.last_page && messagesPage > response.last_page) {
                    messagesLastPage = true;
                }
            } else if (!append) {
                showWelcomeMessage();
            }
        })
        .fail(function(xhr, status, error) {
            showErrorMessage('Failed to load messages. Please try again.');
        })
        .always(function() {
            $('#elmLoader').hide();
            isMessagesLoading = false;
            if (!append) scrollToBottom();
        });
    }

    // Helper for infinite scroll: prepend message HTML
    function appendMessageHtml(message, isSent) {
        const messageClass = isSent ? 'right' : 'left';
        const senderName = message.sender_name || (isSent ? '{{ auth()->user()->name }}' : (selectedUserData.name || 'Unknown'));
        const senderAvatar = message.sender_avatar || (isSent ? ('{{ auth()->user()->profile_photo_url ?? "https://ui-avatars.com/api/?name=" . urlencode(auth()->user()->name) . "&background=0D8ABC&color=fff" }}') : (selectedUserData.avatar || 'https://ui-avatars.com/api/?name=User&background=0D8ABC&color=fff'));
        const content = typeof message.content === 'undefined' || message.content === null ? '' : message.content;
        const createdAt = message.created_at || new Date().toISOString();
        const avatarHtml = !isSent ? `<div class="chat-avatar">
            <img src="${senderAvatar}" alt="${senderName}" class="rounded-circle">
        </div>` : '';
        const bubbleClass = isSent ? 'chat-bubble-sent' : 'chat-bubble-received';
        return `
            <li class="chat-list ${messageClass}" data-message-id="${message.id || ''}">
                <div class="conversation-list">
                    ${avatarHtml}
                    <div class="user-chat-content position-relative">
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content ${bubbleClass}">
                                <p class="mb-0 ctext-content">${escapeHtml(content)}</p>
                                <div class="dropdown align-self-start message-box-drop">
                                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="ri-more-2-fill"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item copy-message" href="#"><i class="ri-file-copy-line me-2 text-muted align-bottom"></i>Copy</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="conversation-name">
                                <small class="text-muted time">${formatTime(createdAt)}</small>
                                ${isSent ? `<span class="text-success check-message-icon"><i class="ri-check-double-line align-bottom"></i></span>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        `;
    }
    
    function appendMessage(message, isSent) {
        const messageClass = isSent ? 'right' : 'left';
        // Fallbacks for undefined/null values
        const senderName = message.sender_name || (isSent ? '{{ auth()->user()->name }}' : (selectedUserData.name || 'Unknown'));
        const senderAvatar = message.sender_avatar || (isSent ? ('{{ auth()->user()->profile_photo_url ?? "https://ui-avatars.com/api/?name=" . urlencode(auth()->user()->name) . "&background=0D8ABC&color=fff" }}') : (selectedUserData.avatar || 'https://ui-avatars.com/api/?name=User&background=0D8ABC&color=fff'));
        const content = typeof message.content === 'undefined' || message.content === null ? '' : message.content;
        const createdAt = message.created_at || new Date().toISOString();
        const avatarHtml = !isSent ? `<div class="chat-avatar">
            <img src="${senderAvatar}" alt="${senderName}" class="rounded-circle">
        </div>` : '';
        const bubbleClass = isSent ? 'chat-bubble-sent' : 'chat-bubble-received';
        const messageHtml = `
            <li class="chat-list ${messageClass}" data-message-id="${message.id || ''}">
                <div class="conversation-list">
                    ${avatarHtml}
                    <div class="user-chat-content position-relative">
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content ${bubbleClass}">
                                <p class="mb-0 ctext-content">${escapeHtml(content)}</p>
                                <div class="dropdown align-self-start message-box-drop">
                                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="ri-more-2-fill"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item copy-message" href="#"><i class="ri-file-copy-line me-2 text-muted align-bottom"></i>Copy</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="conversation-name">
                                <small class="text-muted time">${formatTime(createdAt)}</small>
                                ${isSent ? `<span class="text-success check-message-icon"><i class="ri-check-double-line align-bottom"></i></span>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        `;
        $('#users-conversation').append(messageHtml);
        scrollToBottom();
    }
    
    function showWelcomeMessage() {
        const welcomeHtml = `
            <li class="chat-list welcome-message">
                <div class="conversation-list">
                    <div class="user-chat-content">
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content text-center">
                                <div class="avatar-md mx-auto mb-3">
                                    <img src="${selectedUserData.avatar}" alt="${selectedUserData.name}" class="rounded-circle">
                                </div>
                                <h6 class="mb-1">Start conversation with ${selectedUserData.name}</h6>
                                <p class="text-muted mb-0 fs-12">Send a message to begin chatting</p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        `;
        $('#users-conversation').append(welcomeHtml);
    }
    
    function showErrorMessage(message) {
        const errorHtml = `
            <li class="chat-list">
                <div class="conversation-list">
                    <div class="user-chat-content">
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content text-center">
                                <div class="avatar-sm mx-auto mb-2">
                                    <div class="avatar-title rounded-circle bg-soft-danger text-danger">
                                        <i class="ri-error-warning-line"></i>
                                    </div>
                                </div>
                                <p class="mb-0 text-danger fs-13">${message}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        `;
        $('#users-conversation').append(errorHtml);
    }
    
    function removeWelcomeMessage() {
        $('.welcome-message').remove();
    }
    
    function handleCopyMessage(e) {
        e.preventDefault();
        const messageText = $(this).closest('.ctext-wrap').find('.ctext-content').text();
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(messageText).then(function() {
                $('#copyClipBoard').fadeIn().delay(2000).fadeOut();
            }).catch(function() {
                fallbackCopyText(messageText);
            });
        } else {
            fallbackCopyText(messageText);
        }
    }
    
    function fallbackCopyText(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            $('#copyClipBoard').fadeIn().delay(2000).fadeOut();
        } catch (err) {
            console.error('Failed to copy text: ', err);
        }
        document.body.removeChild(textArea);
    }
    
    function showFeedback(message, type = 'error') {
        const feedback = $('#chat-feedback');
        feedback.removeClass('text-success text-danger')
                .addClass(type === 'success' ? 'text-success' : 'text-danger')
                .text(message)
                .show();
    }
    
    function hideFeedback() {
        $('#chat-feedback').hide();
    }
    
    function scrollToBottom() {
        const chatContainer = $('#chat-messages')[0];
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    }
    
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
    }
    
    function formatTime(dateString) {
        try {
            const date = new Date(dateString);
            const now = new Date();
            const diff = now - date;
            
            if (diff < 60000) {
                return 'Just now';
            }
            if (diff < 3600000) {
                const minutes = Math.floor(diff / 60000);
                return `${minutes} min${minutes > 1 ? 's' : ''} ago`;
            }
            if (date.toDateString() === now.toDateString()) {
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        } catch (error) {
            return 'Invalid date';
        }
    }
    
    setInterval(function() {
        refreshUserStatus();
    }, 30000);
    
    function refreshUserStatus() {
        $.ajax({
            url: '/chat/users/status',
            method: 'GET',
            timeout: 5000
        })
        .done(function(users) {
            if (users && Array.isArray(users)) {
                users.forEach(function(user) {
                    const userItem = $(`.user-item[data-user-id="${user.id}"]`);
                    if (userItem.length) {
                        userItem.attr('data-is-online', user.is_online ? '1' : '0')
                               .attr('data-user-status', user.is_online ? 'Online' : 'Offline');
                        
                        const indicator = userItem.find('.online-indicator, .offline-indicator');
                        indicator.removeClass('online-indicator offline-indicator')
                                .addClass(user.is_online ? 'online-indicator' : 'offline-indicator');
                        
                        const badge = userItem.find('.badge');
                        badge.removeClass('bg-success-subtle text-success bg-secondary-subtle text-secondary')
                             .addClass(user.is_online ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary')
                             .text(user.is_online ? 'Online' : 'Offline');
                        
                        if (selectedUserId && selectedUserId == user.id) {
                            selectedUserData.isOnline = user.is_online;
                            selectedUserData.status = user.is_online ? 'Online' : 'Offline';
                            updateChatHeader();
                        }
                    }
                });
            }
        })
        .fail(function(xhr, status, error) {
            console.log('Failed to refresh user status:', error);
        });
    }
    
    if (typeof Pusher !== 'undefined') {
        initializePusher();
    }
    
    function initializePusher() {
        try {
            const pusher = new Pusher('your-pusher-key', {
                cluster: 'your-pusher-cluster',
                encrypted: true
            });
            
            const authUserId = $('#auth-user-id').val();
            const channel = pusher.subscribe(`private-user.${authUserId}`);
            
            channel.bind('message.sent', function(data) {
                if (data.message && selectedUserId && data.message.sender_id == selectedUserId) {
                    appendMessage(data.message, false);
                    removeWelcomeMessage();
                }
            });
            
            channel.bind('user.status.changed', function(data) {
                if (data.user) {
                    updateUserStatus(data.user);
                }
            });
        } catch (error) {
            console.log('Pusher initialization failed:', error);
        }
    }
    
    function updateUserStatus(user) {
        const userItem = $(`.user-item[data-user-id="${user.id}"]`);
        if (userItem.length) {
            userItem.attr('data-is-online', user.is_online ? '1' : '0')
                   .attr('data-user-status', user.is_online ? 'Online' : 'Offline');
            
            const indicator = userItem.find('.online-indicator, .offline-indicator');
            indicator.removeClass('online-indicator offline-indicator')
                    .addClass(user.is_online ? 'online-indicator' : 'offline-indicator');
            
            const badge = userItem.find('.badge');
            badge.removeClass('bg-success-subtle text-success bg-secondary-subtle text-secondary')
                 .addClass(user.is_online ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary')
                 .text(user.is_online ? 'Online' : 'Offline');
            
            if (selectedUserId && selectedUserId == user.id) {
                selectedUserData.isOnline = user.is_online;
                selectedUserData.status = user.is_online ? 'Online' : 'Offline';
                updateChatHeader();
            }
        }
    }
    
    $(window).on('focus', function() {
        if (selectedUserId) {
            markMessagesAsRead(selectedUserId);
        }
    });
    
    function markMessagesAsRead(userId) {
        $.ajax({
            url: '/chat/messages/mark-read',
            method: 'POST',
            data: {
                user_id: userId,
                _token: $('#csrf-token').val()
            }
        })
        .done(function() {
            $('.chat-list.left .check-message-icon').removeClass('text-muted').addClass('text-success');
        })
        .fail(function(xhr, status, error) {
            console.log('Failed to mark messages as read:', error);
        });
    }
    
    $('#emoji-btn').on('click', function(e) {
        e.preventDefault();
        console.log('Emoji picker clicked');
    });
});
</script>
@endsection