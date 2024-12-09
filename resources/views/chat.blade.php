<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="stylesheet" href="https://unpkg.com/@joeattardi/emoji-button@2.2.2/dist/index.css"> --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>Chat</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400&family=Itim&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        .bona-nova-sc-regular {
            font-family: "Bona Nova SC", serif;
            font-weight: 400;
            font-style: normal;
        }

        .bona-nova-sc-bold {
            font-family: "Bona Nova SC", serif;
            font-weight: 700;
            font-style: normal;
        }

        .bona-nova-sc-regular-italic {
            font-family: "Bona Nova SC", serif;
            font-weight: 400;
            font-style: italic;
        }


        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            background-color: #1c1c1c;
            color: #e0e0e0;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: #2e2e2e;
            border-bottom: 1px solid #444;
        }

        .header a {
            text-decoration: none;
            color: inherit;
        }

        .header svg {
            width: 24px;
            height: 24px;
            fill: #e0e0e0;
        }

        .username {
            font-weight: bold;
            color: #e0e0e0;
        }

        .chat-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px 15px;
            background-color: #2a2a2a;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .message {
            padding: 14px 18px;
            border-radius: 20px;
            max-width: 65%;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
            position: relative;
            font-size: 14px;
        }

        .message.right {
            align-self: flex-end;
            background-color: #3a3a3a;
            color: #e0e0e0;
            text-align: right;
        }

        .message.left {
            align-self: flex-start;
            background-color: #4a4a4a;
            color: #e0e0e0;
            text-align: left;
        }

        .message .timestamp {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }

        .footer {
            display: flex;
            align-items: center;
            padding: 15px;
            border-top: 1px solid #444;
            background-color: #2e2e2e;
        }

        .footer textarea {
            flex: 1;
            padding: 12px 15px;
            border-radius: 20px;
            border: 1px solid #555;
            background-color: #333;
            color: #e0e0e0;
            resize: none;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            outline: none;
        }

        .footer button {
            width: 45px;
            height: 45px;
            margin-left: 10px;
            border: none;
            background-color: #4a4a4a;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .footer button:hover {
            background-color: #2e2e2e;
        }

        .footer button svg {
            width: 20px;
            height: 20px;
            fill: white;
        }
    </style>
</head>

<body>

    <div class="header">
        <a href="/dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="back-button">
                <path class="icon-fill"
                    d="M9.41 11H17a1 1 0 0 1 0 2H9.41l2.3 2.3a1 1 0 1 1-1.42 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 0 1 1.42 1.4L9.4 11z" />
            </svg>
        </a>
        <div class="username">{{ $user->name }}</div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-dots">
            <path class="icon-fill" fill-rule="evenodd"
                d="M12 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
        </svg>
    </div>

    <div class="chat-content" id="chat-content">
        @foreach ($messages as $message)
            <div class="message {{ $message->sender_id == Auth::id() ? 'right' : 'left' }}">
                {{ $message->message }}
                <div class="timestamp">
                    {{ $message->created_at->format('h:i A') }}
                </div>
            </div>
        @endforeach
    </div>

    <div class="footer">
        <textarea id="message-input" rows="1" placeholder="Type a message..."></textarea>
        <button id="emoji-button">😊</button>
        <button id="send-button">
            <svg class="paper-plane" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane"
                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor"
                    d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z">
                </path>
            </svg>
        </button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/emoji-button@2.2.2/dist/index.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sendButton = document.getElementById('send-button');
            const messageInput = document.getElementById('message-input');
            const chatContent = document.getElementById('chat-content');
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';
            const emojiButtonElement = document.getElementById('emoji-button');

            if (typeof EmojiButton !== 'undefined') {
                const picker = new EmojiButton();

                emojiButtonElement.addEventListener('click', () => {
                    picker.showPicker(emojiButtonElement);
                });

                picker.on('emoji', emoji => {
                    messageInput.value += emoji;
                });
            } else {
                console.error('EmojiButton is not defined');
            }



            sendButton.addEventListener('click', function() {
                const message = messageInput.value;
                const reciever_id = '{{ $user->id }}';

                if (message.trim() === '') return;

                const senderMessageHTML = `
                    <div class="message right">
                        ${message}
                        <div class="timestamp">
                            Just now
                        </div>
                    </div>`;
                chatContent.insertAdjacentHTML('beforeend', senderMessageHTML);
                chatContent.scrollTop = chatContent.scrollHeight;
                messageInput.value = '';

                fetch('{{ route('send-message') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            message,
                            reciever_id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status !== 'Message sent successfully') {
                            console.error('Failed to send message:', data);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            if (window.Echo) {
                const userId = '{{ Auth::id() }}';
                Echo.private(`chat-channel.${userId}`)
                    .listen('.MessageSendEvent', (event) => {
                        // console.log('Received event:', event);
                        if (event.message && event.message.message) {
                            const receiverMessageHTML = `
                                <div class="message left">
                                    ${event.message.message}
                                    <div class="timestamp">
                                        Just now
                                    </div>
                                </div>`;
                            chatContent.insertAdjacentHTML('beforeend', receiverMessageHTML);
                            chatContent.scrollTop = chatContent.scrollHeight;
                        } else {
                            console.error('Invalid message structure:', event);
                        }
                    });
            } else {
                console.error('Echo is not defined');
            }

        });
    </script>

</body>

</html>
