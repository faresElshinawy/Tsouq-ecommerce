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
                <div class="container mt-3">
                    <h1 class="text-center card-header">Customers Messages</h1>

                    <div class="card">
                        <div class="card-header">
                            <div class="input-group rounded-square">
                                <div class="input-group-prepend rounded-square">
                                    <span class="input-group-text  py-3 px-3"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" name="query" id="chat-search"
                                    placeholder="Search...">
                            </div>
                        </div>
                        <div id="search-result" class="mx-3 card-boady">
                            @foreach ($chats as $chat)
                                <div class="d-flex justify-content-between">
                                    <a class="dropdown-item p-2" href="{{ route('chats.show', ['chat' => $chat->id]) }}"
                                            type="button">
                                        <div class="chat-item rounded {{ $chat->messages->where('status', '0')->where('sender',$chat->user->id)->count() > 0 ? 'btn-outline-primary' : 'btn-outline-dark' }} p-2"
                                            id="chat-item-{{ $chat->id }}">
                                            <div class="chat-avatar">
                                                {{ $chat->user->name }}
                                            </div>
                                            <div class="chat-status text-muted d-flex justify-content-between">
                                                Chat with {{ $chat->user->name }}
                                                @if ($chat->messages->where('status', '0')->where('sender', $chat->user->id)->count())
                                                    <span>{{ $chat->messages->where('status', '0')->where('sender', $chat->user->id)->count() }}
                                                        unread messages</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            <div class="m-2">
                                {{ $chats->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="col-md-8">

            <div id="chat-messages">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center text-muted fs-3 py-5">
                            Select Chat And Start Messaging
                        </div>
                    </div>
                </div>
            </div>

        </div> --}}

@endsection


@section('js')

    <script>
        let sendMessageTimeout;

        $(document).ready(function() {
            $(document).on('keyup', '#chat-search', function(e) {
                e.preventDefault();
                query = this.value;
                $.ajax({
                    url: "{{ route('chats.search') }}",
                    type: 'POST',
                    data: {
                        "query": query,
                        "_token": "{{ csrf_token() }}"
                    },
                    datatype: 'html',
                    cache: false,
                    success: function(data) {
                        $('#search-result').empty().html(data)
                    }
                })
            });


            $(document).on('click', '#ajax-pagination a', function(e) {
                e.preventDefault();
                var query = $("#chats-search").val();
                $.ajax({
                    url: $(this).attr('href'),
                    type: "post",
                    datatype: 'html',
                    data: {
                        "query": query,
                        '_token': "{{ csrf_token() }}"
                    },
                    cache: false,
                    success: function(data) {
                        $('#search-result').html('');
                        $('#search-result').html(data);
                    }
                });
            })


        });


    </script>


@endsection
