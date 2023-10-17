    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('assets') }}/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{ asset('assets') }}/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets') }}/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets') }}/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets') }}/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https:/buttons.github.io/buttons.js"></script>

    <script src="{{ asset('assets') }}/js/ui-toasts.js"></script>



    @can('notification access')
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script>
            $(document).ready(function() {
                // Enable pusher logging - don't include this in production
                // Pusher.logToConsole = true;

                var pusher = new Pusher("{{ env('PUSHER_APP_Key') }}", {
                    cluster: 'ap2'
                });

                var userChannel = pusher.subscribe('user-channel');
                userChannel.bind('user-event', function(data) {
                    var userEditUrl = "{{ route('users.edit', ['user' => ':userId']) }}";
                    userEditUrl = userEditUrl.replace(':userId', data.data.user_id);
                    var html = `
                                <a class="dropdown-item p-2" href="${userEditUrl}">
                                    <div class="notification-item rounded bg-label-muted btn-outline-primary p-2">
                                        <div class="notification-avatar">${data.data.user_name} ${data.data.action}</div>
                                        <span class="text-muted">${data.data.created_at}</span>
                                    </div>
                                </a>
                            `;
                    $('#notifications-container-real-time-result').append(html);
                    $('#notification-holder-message').empty();
                    $('#notificationsDropdown').addClass('text-primary');
                });

                var orderChannel = pusher.subscribe('order-channel');
                orderChannel.bind('order-event', function(data) {
                    var orderEditUrl = "{{ route('orders.edit', ['order' => ':orderId']) }}";
                    orderEditUrl = orderEditUrl.replace(':orderId', data.data.order_id);
                    var html = `
                                        <a class="dropdown-item p-2"
                                            href="${orderEditUrl}">
                                            <div class="notification-item rounded bg-label-muted btn-outline-primary p-2"
                                                id="notification-item">
                                                <div class="notification-avatar ">
                                                    ${data.data.username}
                                                </div>
                                                <div class="notification-content ">
                                                    ${data.data.notify_type}  ${data.data.order_code} ${data.data.action}
                                                </div>
                                                <span class="text-muted">${data.data.created_at}</span>
                                            </div>
                                        </a>
                                `;
                    if (data.data.user_id != "{{ Auth::user()->id }}") {
                        $('#notifications-container-real-time-result').append(html);
                        $('#notification-holder-message').empty();
                        $('#notificationsDropdown').addClass('text-primary');
                    }
                });



                var productChannel = pusher.subscribe('product-channel');
                productChannel.bind('product-create', function(data) {
                    var productEditUrl = "{{ route('products.edit', ['product' => ':productId']) }}";
                    productEditUrl = productEditUrl.replace(':productId', data.data.product_id);
                    console.log(data.data.created_at)
                    var html = `
                                        <a class="dropdown-item p-2"
                                            href="${productEditUrl}">
                                            <div class="notification-item rounded bg-label-muted btn-outline-primary p-2"
                                                id="notification-item">
                                                <div class="notification-avatar ">
                                                    ${data.data.username}
                                                </div>
                                                <div class="notification-content ">
                                                    ${data.data.notify_type}  ${data.data.product_name} ${data.data.action}
                                                </div>
                                                <span class="text-muted">${data.created_at}</span>
                                            </div>
                                        </a>
                                `;
                    if (data.data.user_id != "{{ Auth::user()->id }}") {
                        $('#notifications-container-real-time-result').append(html);
                        $('#notification-holder-message').empty();
                        $('#notificationsDropdown').addClass('text-primary');
                    }
                });


                productChannel.bind('product-update', function(data) {
                    var productEditUrl = "{{ route('products.edit', ['product' => ':productId']) }}";
                    productEditUrl = productEditUrl.replace(':productId', data.data.product_id);
                    console.log(data.data.created_at)
                    var html = `
                                        <a class="dropdown-item p-2"
                                            href="${productEditUrl}">
                                            <div class="notification-item rounded bg-label-muted btn-outline-primary p-2"
                                                id="notification-item">
                                                <div class="notification-avatar ">
                                                    ${data.data.username}
                                                </div>
                                                <div class="notification-content ">
                                                    ${data.data.notify_type}  ${data.data.product_name} ${data.data.action}
                                                </div>
                                                <span class="text-muted">${data.created_at}</span>
                                            </div>
                                        </a>
                                `;
                    if (data.data.user_id != "{{ Auth::user()->id }}") {
                        $('#notifications-container-real-time-result').append(html);
                        $('#notification-holder-message').empty();
                        $('#notificationsDropdown').addClass('text-primary');
                    }
                });


                // var chatChannel = pusher.subscribe('chat');

                // chatChannel.bind('new-message', function(data) {
                //     var chatUrl = "{{ route('chats.show', ['chat' => ':chatId']) }}";
                //     chatUrl = chatUrl.replace(':chatId', data.message.chat_id);
                //     console.log(data.message.created_at)
                //     var html = `
        //                         <a class="dropdown-item p-2"
        //                             href="${chatUrl}">
        //                             <div class="notification-item rounded bg-label-muted btn-outline-primary p-2"
        //                                 id="notification-item">
        //                                 <div class="notification-avatar ">
        //                                 ${data.username}
        //                                 </div>
        //                                 <div class="notification-content text-muted">
        //                                         ${data.message.message}
        //                                 </div>
        //                                 <span class="text-muted">${data.created_at}</span>
        //                             </div>
        //                         </a>
        //                 `;
                //     $('#notifications-container-real-time-result').append(html);
                //     $('#notification-holder-message').empty();
                //     $('#notificationsDropdown').addClass('text-primary');
                // });


            })
        </script>

        @can('customer servieces')
            <script>
                $(document).ready(function() {

                    var pusher = new Pusher("{{ env('PUSHER_APP_Key') }}", {
                        cluster: 'ap2'
                    });

                    var chatChannel = pusher.subscribe('chat');

                    chatChannel.bind('new-message', function(data) {
                        var chatUrl = "{{ route('chats.show', ['chat' => ':chatId']) }}";
                        chatUrl = chatUrl.replace(':chatId', data.message.chat_id);
                        console.log(data.message.created_at)
                        var html = `
                        <a class="dropdown-item p-2"
                            href="${chatUrl}">
                            <div class="notification-item rounded bg-label-muted btn-outline-primary p-2"
                                id="notification-item">
                                <div class="notification-avatar ">
                                ${data.username}
                                </div>
                                <div class="notification-content text-muted">
                                        ${data.message.message}
                                </div>
                                <span class="text-muted">${data.created_at}</span>
                            </div>
                        </a>
                `;
                        $('#notifications-container-real-time-result').append(html);
                        $('#notification-holder-message').empty();
                        $('#notificationsDropdown').addClass('text-primary');
                    });
                });
            </script>
        @endcan
    @endcan
