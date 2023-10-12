
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
