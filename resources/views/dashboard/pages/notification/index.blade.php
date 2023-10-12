@extends('dashboard.layouts.master')


@section('title', 'sizes')

@section('content')
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Notifications /</span> Notifications</h4>
            <div class="card">
                <div class="container mt-3">
                    <h1 class="text-center card-header">Notifications</h1>
                    @if (Auth::user()->notifications->count())
                        <div class="m-3 d-flex justify-content-between">
                            <div id="delete-all-div">
                                <a class="btn btn-danger text-white" id="delete-all-btn">Delete All Notifications</a>
                            </div>
                            @if (Auth::user()->unreadNotifications->count())
                                <div id="read-all-div">
                                    <a class="btn btn-dark text-white" id="read-all-btn">Read All</a>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div id="notification-list-div" class="list-group mt-3">
                        @if (Auth::user()->notifications->count())
                            @foreach ($notifications as $notification)
                                @switch($notification->data['notify_type'])
                                    @case('product')
                                        <div class="d-flex justify-content-between">
                                            <a class="dropdown-item p-2"
                                                href="{{ route('products.edit', ['product' => $notification->data['product_id']]) }}">
                                                <div class="notification-item rounded  {{ $notification->read_at ? 'btn-outline-dark' : 'btn-outline-primary' }} p-2 "
                                                    id="notification-item">
                                                    <div class="notification-avatar ">
                                                        {{ $notification->data['username'] }}
                                                    </div>
                                                    <div class="notification-content ">
                                                        {{ $notification->data['notify_type'] . ' ' . $notification->data['product_name'] . ' ' . $notification->data['action'] }}
                                                    </div>
                                                    <span class="text-muted">{{ \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans() }}</span>
                                                </div>
                                            </a>
                                            <a class="btn btn-muted mt-3 "
                                                onclick="$('#notification-{{ $notification->id }}-delete').submit()"><i
                                                    class='bx bx-trash'></i>Delete</a>
                                            <form
                                                action="{{ route('notifications.destroy', ['notification' => $notification->id]) }}"
                                                method="POST" id="notification-{{ $notification->id }}-delete">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                    @break

                                    @case('order')
                                        <div class="d-flex justify-content-between">
                                            <a class="dropdown-item p-2"
                                                href="{{ route('orders.edit', ['order' => $notification->data['order_id']]) }}">
                                                <div class="notification-item rounded bg-label-muted {{ $notification->read_at ? 'btn-outline-dark' : 'btn-outline-primary' }} p-2"
                                                    id="notification-item">
                                                    <div class="notification-avatar">
                                                        {{ $notification->data['username'] }}
                                                    </div>
                                                    <div class="notification-content ">
                                                        {{ $notification->data['notify_type'] . ' ' . $notification->data['order_code'] . ' ' . $notification->data['action'] }}
                                                    </div>
                                                    <span class="text-muted">{{ \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans() }}</span>
                                                </div>
                                            </a>
                                            <a class="btn btn-muted mt-3 "
                                                onclick="$('#notification-{{ $notification->id }}-delete').submit()"><i
                                                    class='bx bx-trash'></i>Delete</a>
                                            <form
                                                action="{{ route('notifications.destroy', ['notification' => $notification->id]) }}"
                                                method="POST" id="notification-{{ $notification->id }}-delete">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                    @break

                                    @case('user')
                                        <div class="d-flex justify-content-between">
                                            <a class="dropdown-item p-2"
                                                href="{{ route('users.edit', ['user' => $notification->data['user_id']]) }}">
                                                <div class="notification-item rounded bg-label-muted {{ $notification->read_at ? 'btn-outline-dark' : 'btn-outline-primary' }} p-2"
                                                    id="notification-item">
                                                    <div class="notification-avatar ">
                                                        {{ $notification->data['user_name'] }}
                                                    </div>
                                                    <span class="text-muted">{{ \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans() }}</span>
                                                </div>
                                            </a>
                                            <a class="btn btn-muted mt-3 "
                                                onclick="$('#notification-{{ $notification->id }}-delete').submit()"><i
                                                    class='bx bx-trash'></i>Delete</a>
                                            <form
                                                action="{{ route('notifications.destroy', ['notification' => $notification->id]) }}"
                                                method="POST" id="notification-{{ $notification->id }}-delete">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                    @break

                                    @case('chat')
                                        <div class="d-flex justify-content-between">
                                            <a class="dropdown-item p-2"
                                                href="{{ route('chats.show', [$notification->data['chat_id']]) }}">
                                                <div class="notification-item rounded bg-label-muted {{ $notification->read_at ? 'btn-outline-dark' : 'btn-outline-primary' }} p-2"
                                                    id="notification-item">
                                                    <div class="notification-avatar ">
                                                        {{ $notification->data['username'] }}
                                                        <div class="notification-content ml-1 text-muted">
                                                            {{ $notification->data['message'] }}
                                                        </div>
                                                    </div>
                                                    <span class="text-muted">{{ \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans() }}</span>
                                                </div>
                                            </a>
                                            <a class="btn btn-muted mt-3 "
                                                onclick="$('#notification-{{ $notification->id }}-delete').submit()"><i
                                                    class='bx bx-trash'></i>Delete</a>

                                        </div>
                                    @break

                                    @default
                                @endswitch
                            @endforeach
                        @else
                            <span class="dropdown-item text-center p-5">There Is No Notifications Yet</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-center" id="notifications-pagiantion">
                    {{$notifications->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            $('#delete-all-btn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('notifications.delete-all') }}",
                    type: 'post',
                    datatype: 'json',
                    cache: false,
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            var html = '<p class="text-primary text-start">' + data.message +
                                '!</p>';
                            var notify_holder =
                                '<span class="dropdown-item text-center p-5">There Is No Notifications Yet</span>';
                            $('#delete-all-btn').hide();
                            $('#read-all-btn').hide();
                            $('#notifications-pagiantion').remove();
                            $('#delete-all-div').prepend(html);
                            $('#notification-list-div').html(notify_holder);
                            $('#notifications-container-real-time-result').empty();
                            $('#notification-holder-message').append(
                                'There Is No Notifications Yet'
                            );
                            $('#notificationsDropdown').removeClass('text-primary');
                        }
                    }
                })
            })

            $('#read-all-btn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('notifications.read-all') }}",
                    type: 'post',
                    datatype: 'json',
                    cache: false,
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            var html = '<p class="text-primary text-start">' + data.message +
                                '!</p>';
                            var notifications = document.querySelectorAll('#notification-item');
                            for (let i = 0; i < notifications.length; i++) {
                                notifications[i].classList.remove('btn-outline-primary');
                                notifications[i].classList.add('btn-outline-dark');
                            }
                            $('#notificationsDropdown').removeClass('btn-outline-primary');
                            $('#read-all-btn').hide();
                            $('#read-all-div').html(html);
                            $('#notificationsDropdown').removeClass('text-primary');
                            $('#dropdown-item').removeClass('text-primary');
                        }
                    }
                })
            })
        });
    </script>

@endsection
