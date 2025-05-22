/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Chat init js
*/

(function () {
    var dummyUserImage = "assets/images/users/user-dummy-img.jpg";
    var dummyMultiUserImage = "assets/images/users/multi-user.jpg";
    var isreplyMessage = false;

    // favourite btn
    document.querySelectorAll(".favourite-btn").forEach(function (item) {
        item.addEventListener("click", function (event) {
            this.classList.toggle("active");
        });
    });

    // toggleSelected
    function toggleSelected() {
        var userChatElement = document.querySelectorAll(".user-chat");
        Array.from(document.querySelectorAll(".chat-user-list li a")).forEach(function (item) {
            item.addEventListener("click", function (event) {
                userChatElement.forEach(function (elm) {
                    elm.classList.add("user-chat-show");
                });

                // chat user list link active
                var chatUserList = document.querySelector(".chat-user-list li.active");
                if (chatUserList) chatUserList.classList.remove("active");
                this.parentNode.classList.add("active");
            });
        });

        // user-chat-remove
        document.querySelectorAll(".user-chat-remove").forEach(function (item) {
            item.addEventListener("click", function (event) {
                userChatElement.forEach(function (elm) {
                    elm.classList.remove("user-chat-show");
                });
            });
        });
    }

    //User current Id
    var currentChatId = "users-chat";
    var currentSelectedChat = "users";
    var url = "assets/json/";
    var userChatId = 1;

    scrollToBottom(currentChatId);

    function updateSelectedChat() {
        if (currentSelectedChat == "users") {
            document.getElementById("channel-chat").style.display = "none";
            document.getElementById("users-chat").style.display = "block";
            getChatMessages(url + "chats.json");
        } else {
            document.getElementById("channel-chat").style.display = "block";
            document.getElementById("users-chat").style.display = "none";
            getChatMessages(url + "chats.json");
        }
    }
    updateSelectedChat();

    //Chat Message
    function getChatMessages(jsonFileUrl) {
        $.getJSON(jsonFileUrl, function (data) {
            var chatsData =
                currentSelectedChat == "users" ? data[0].chats : data[0].channel_chat;

            document.getElementById(
                currentSelectedChat + "-conversation"
            ).innerHTML = "";
            var isContinue = 0;
            chatsData.forEach(function (isChat, index) {

                if (isContinue > 0) {
                    isContinue = isContinue - 1;
                    return;
                }
                var isAlighn = isChat.from_id == userChatId ? " right" : " left";

                var msgHTML = '<li class="chat-list' + isAlighn + '" id=' + isChat.id + '>\
                    <div class="conversation-list">';
                msgHTML += '<div class="user-chat-content">';
                msgHTML += getMsg(isChat.id, isChat.msg, isChat.has_images, isChat.has_files, isChat.has_dropDown);
                if (chatsData[index + 1] && isChat.from_id == chatsData[index + 1]["from_id"]) {
                    isContinue = getNextMsgCounts(chatsData, index, isChat.from_id);
                    msgHTML += getNextMsgs(chatsData, index, isChat.from_id, isContinue);
                }

                msgHTML +=
                    '<div class="conversation-name"><small class="text-muted time">' + isChat.datetime +
                    '</small> <span class="text-success check-message-icon"><i class="bx bx-check-double"></i></span></div>';
                msgHTML += "</div>\
            </div>\
        </li>";

                document.getElementById(currentSelectedChat + "-conversation").innerHTML += msgHTML;
            });
            deleteMessage();
            deleteChannelMessage();
            deleteImage();
            replyMessage();
            replyChannelMessage();
            copyMessage();
            copyChannelMessage();
            copyClipboard();
            scrollToBottom("users-chat");
            updateLightbox();
        });
    }

    // GLightbox Popup
    function updateLightbox() {
        var lightbox = GLightbox({
            selector: ".popup-img",
            title: false,
        });
    }

    // Scroll to Bottom
    function scrollToBottom(id) {
        setTimeout(function () {
            var chatConversation = document.getElementById(id).querySelector("#chat-conversation");
            if (chatConversation) {
                chatConversation.scrollTop = chatConversation.scrollHeight;
            }
        }, 100);
    }

    //chat form
    var chatForm = document.querySelector("#chatinput-form");
    var chatInput = document.querySelector("#chat-input");
    var chatInputfeedback = document.querySelector(".chat-input-feedback");

    function currentTime() {
        var ampm = new Date().getHours() >= 12 ? "pm" : "am";
        var hour =
            new Date().getHours() > 12 ?
                new Date().getHours() % 12 :
                new Date().getHours();
        var minute =
            new Date().getMinutes() < 10 ?
                "0" + new Date().getMinutes() :
                new Date().getMinutes();
        if (hour < 10) {
            return "0" + hour + ":" + minute + " " + ampm;
        } else {
            return hour + ":" + minute + " " + ampm;
        }
    }
    setInterval(currentTime, 1000);

    var messageIds = 0;

    if (chatForm) {
        chatForm.addEventListener("submit", function (e) {
            e.preventDefault();

            var chatId = currentChatId;
            var chatReplyId = currentChatId;

            var chatInputValue = chatInput.value

            if (chatInputValue.length === 0) {
                chatInputfeedback.classList.add("show");
                setTimeout(function () {
                    chatInputfeedback.classList.remove("show");
                }, 2000);
            } else {
                if (isreplyMessage == true) {
                    getReplyChatList(chatReplyId, chatInputValue);
                    isreplyMessage = false;
                } else {
                    getChatList(chatId, chatInputValue);
                }
                scrollToBottom(chatId || chatReplyId);
            }
            chatInput.value = "";

            //reply msg remove textarea
            document.getElementById("close_toggle").click();
        })
    }

    $(function () {
        let selectedUserId = null;
        const authUserId = $('#auth-user-id').val();

        // Setup Echo
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: window.PUSHER_APP_KEY || '',
            cluster: window.PUSHER_APP_CLUSTER || '',
            forceTLS: true,
            encrypted: true,
        });

        // User selection
        $('.user-item').on('click', function () {
            selectedUserId = $(this).data('id');
            fetchMessages();
        });

        // Fetch messages
        function fetchMessages() {
            if (!selectedUserId) return;
            $.get('/chat/messages/' + selectedUserId, function (messages) {
                $('#chat-messages').html('');
                messages.forEach(function (msg) {
                    const align = msg.sender_id == authUserId ? 'text-end' : 'text-start';
                    $('#chat-messages').append('<div class="mb-2 ' + align + '"><span class="badge bg-light text-dark">' + msg.message + '</span></div>');
                });
                $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
            });
        }

        // Send message
        $('#chat-form').on('submit', function (e) {
            e.preventDefault();
            const message = $('#chat-input').val();
            if (!message || !selectedUserId) return;
            $.post('/chat/send', {
                receiver_id: selectedUserId,
                message: message,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function (msg) {
                $('#chat-input').val('');
                fetchMessages();
            });
        });

        // Listen for new messages
        if (authUserId) {
            window.Echo.private('chat.' + authUserId)
                .listen('ChatMessageSent', (e) => {
                    if (selectedUserId == e.sender_id) {
                        fetchMessages();
                    }
                });
        }
    });

})();
//Search Message
function searchMessages() {
    var searchInput, searchFilter, searchUL, searchLI, a, i, txtValue;
    searchInput = document.getElementById("searchMessage");
    searchFilter = searchInput.value.toUpperCase();
    searchUL = document.getElementById("users-conversation");
    searchLI = searchUL.getElementsByTagName("li");
    Array.from(searchLI).forEach(function (search) {
        a = search.getElementsByTagName("p")[0] ? search.getElementsByTagName("p")[0] : '';
        txtValue = a.textContent || a.innerText ? a.textContent || a.innerText : '';
        if (txtValue.toUpperCase().indexOf(searchFilter) > -1) {
            search.style.display = "";
        } else {
            search.style.display = "none";
        }
    });
};

// chat-conversation
document.getElementById('chat-conversation').scrollTop = document.getElementById("users-conversation").scrollHeight;