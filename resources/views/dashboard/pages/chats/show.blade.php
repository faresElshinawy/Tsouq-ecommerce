@extends('dashboard.layouts.master')


@section('title', 'Customer Service Chat')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/chat.css') }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twemoji-picker/2.2.2/twemoji-picker.min.css">
@endsection

@section('content')

    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Chats /</span> Chats</h4>
            <div class="card">

                <div class="card chat-app">
                    <div class="card-header">
                        <div class="media">
                            <div class="media-body">
                                <h5 class="mt-0">{{ $chat->user->name }}</h5>
                                <span class="text-muted">
                                    @if (Cache::has('user-online' . $chat->user->id))
                                        online
                                    @else
                                        offline
                                    @endif
                                </span>
                                <input type="hidden" value="{{ $chat->id }}" name="chat_id">
                            </div>
                        </div>
                    </div>
                    <div id="chat-messages" class="card-body">
                        <div class="card-body chat-history" id="chat-history">
                            <ul class="list-unstyled" id="chat-{{ $chat->id }}-messages">

                                @foreach ($messages->reverse() as $message)
                                    @if ($message->sender == Auth::user()->id)
                                        <li class="clearfix">
                                            <div class="message-data text-end">
                                                <span
                                                    class="message-data-time">{{ \Carbon\Carbon::parse($message->created_at)->format('h:i A, F jS') }}</span>
                                            </div>
                                            <div class="message customer-message float-right">
                                                {{ $message->message }}
                                            </div>
                                        </li>
                                    @else
                                        <li class="clearfix">
                                            <div class="message-data text-left"> <!-- Adjust this line -->
                                                <span
                                                    class="message-data-time">{{ \Carbon\Carbon::parse($message->created_at)->format('h:i A, F jS') }}</span>
                                            </div>
                                            <div class="message representative-message float-left">
                                                {{ $message->message }}
                                            </div>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>

                        </div>
                        <div class="card-footer">
                            <div id="send-message-error-div" class="ml-3"></div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type your message..." name="message"
                                    onkeypress="newMessage(event)">
                                <div class="input-group-append">
                                    <button class="input-group-text p-3 mx-2 text-white label bg-primary"
                                        id="send-new-message"><i class='bx bx-send'></i></button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>




@endsection


@section('js')

    <script>
        let sendMessageTimeout;

        $(document).ready(function() {

            $(document).on('click', '#send-new-message', function() {

                clearTimeout(sendMessageTimeout);

                sendMessageTimeout = setTimeout(() => {
                    var message = $('input[name="message"][type="text"]').val();
                    var chat_id = $('input[name="chat_id"][type="hidden"]').val();

                    $.ajax({
                        url: "{{ route('chats.messages.store') }}",
                        type: 'post',
                        cache: false,
                        datatype: 'json',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'chat_id': chat_id,
                            'message': message
                        },
                        success: function(data) {
                            if (data.code == 204) {
                                $('#send-message-error-div').empty().append(data
                                    .message)
                            } else if (data.code == 200) {
                                var html = `
                        <li class="clearfix">
                            <div class="message-data text-end">
                                <span class="message-data-time">${data.data.time}</span>
                            </div>
                            <div class="message customer-message float-right">
                                ${data.data.message}
                            </div>
                        </li>
                        `;

                                $('input[name="message"][type="text"]').val('');
                                $(`#chat-${chat_id}-messages`).append(html);
                                $('.chat-history').animate({
                                    scrollTop: $('.chat-history').prop(
                                        "scrollHeight")
                                }, 500);
                            }
                        }
                    })
                }, 100);


            })


        });


        function newMessage(event) {
            clearTimeout(sendMessageTimeout);
            sendMessageTimeout = setTimeout(() => {

                key = event.which;
                if (key == 13) {
                    var message = $('input[name="message"][type="text"]').val();
                    var chat_id = $('input[name="chat_id"][type="hidden"]').val();

                    $.ajax({
                        url: "{{ route('chats.messages.store') }}",
                        type: 'post',
                        cache: false,
                        datatype: 'json',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'chat_id': chat_id,
                            'message': message
                        },
                        success: function(data) {
                            if (data.code == 204) {
                                $('#send-message-error-div').empty().append(data.message)
                            } else if (data.code == 200) {
                                var html = `
                                    <li class="clearfix">
                                        <div class="message-data text-end">
                                            <span class="message-data-time">${data.data.time}</span>
                                        </div>
                                        <div class="message customer-message float-right">
                                            ${data.data.message}
                                        </div>
                                    </li>
                                    `;

                                $('input[name="message"][type="text"]').val('');
                                $(`#chat-${chat_id}-messages`).append(html);
                                $('.chat-history').animate({
                                    scrollTop: $('.chat-history').prop("scrollHeight")
                                }, 500);
                            }
                        }
                    })
                }
            }, 100);

        }


        function changeMessagesStatus(chat_id) {
            $.ajax({
                url: '{{ route('chats.messages.status-change') }}',
                cache: false,
                type: 'post',
                datatype: 'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'chat_id': chat_id
                },
            })
        }

        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: 'ap2'
        });
        var channel = pusher.subscribe(`chat-{{ $chat->id }}`);
        channel.bind('new-message', function(data) {
            if (data.message.sender != "{{ Auth::user()->id }}") {
                var html = `
            <li class="clearfix">
                    <div class="message-data text-left"> <!-- Adjust this line -->
                        <span
                            class="message-data-time">${data.time}</span>
                    </div>
                    <div class="message representative-message float-left">
                        ${data.message.message}
                    </div>
                </li>
            `;
                $(`#chat-{{ $chat->id }}-messages`).append(html);
                $('.chat-history').animate({
                    scrollTop: $('.chat-history').prop(
                        "scrollHeight")
                }, 500);
                changeMessagesStatus('{{ $chat->id }}')
            }
        });


        $('.chat-history').animate({
            scrollTop: $('.chat-history').prop("scrollHeight")
        }, 500);

    </script>


    <script>
        let nextPage = "{{ $messages->nextPageUrl() }}";
        let container = $('.chat-history');
        let messagesContainer = $('#chat-{{ $chat->id }}-messages');
        let currentHeight =  messagesContainer.height();

        function debounce(func, delay) {
            let time;
            return function() {
                clearTimeout(time);
                time = setTimeout(() => func.apply(), delay);
            }
        }

        $(document).ready(function() {
            const debouncedLoadMessages = debounce(function() {
                if (container.scrollTop() === 0) {
                    if (nextPage != 'no more messages') {
                        $.ajax({
                            url: nextPage,
                            method: 'GET',
                            success: function(data) {
                                messagesContainer.prepend(data.data.view);
                                nextPage = data.data.nextPage;
                                var addedMessagesHeight = messagesContainer.height() - currentHeight;
                                container.scrollTop(container.scrollTop() + addedMessagesHeight);
                                currentHeight = messagesContainer.height();
                                if (nextPage == 'no more messages') {
                                    var html =
                                        '<span class="text-muted d-flex justify-content-center">no more messages</span>'
                                        container.prepend(html);
                                }
                            }
                        })
                    }
                }
            }, 250);
            if (nextPage != 'no more messages') {
                container.on('scroll', debouncedLoadMessages);
            }
        })
    </script>


@endsection
