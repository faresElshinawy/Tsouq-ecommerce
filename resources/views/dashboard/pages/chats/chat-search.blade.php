
@if ($chats->count())

@foreach ($chats as $chat)
<div class="d-flex justify-content-between">
    <a class="dropdown-item p-2" href="{{ route('chats.show', ['chat' => $chat->id]) }}"
        onclick="getChatMessages('{{ $chat->id }}')" type="button">
        <div class="chat-item rounded {{ $chat->messages->where('status', '0')->count() > 0 ? 'btn-outline-primary' : 'btn-outline-dark' }} p-2"
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
<div class="m-2" id="ajax-pagination">
    {{$chats->links('pagination::bootstrap-4')}}
</div>
@else
    <div class="m-5 text-center">
        no data found
    </div>
@endif

