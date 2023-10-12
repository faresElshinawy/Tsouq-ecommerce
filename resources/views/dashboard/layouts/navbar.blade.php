<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <form action="{{ route('multi-search.all') }}">
                    <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                        name="multi_search" aria-label="Search..." />
                </form>
            </div>
        </div>
        <!-- /Search -->



        <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle {{ Auth::user()->unreadNotifications->count() ? 'text-primary' : null }}"
                        href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown"
                        id="notification-box-dropdwon" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-1" aria-labelledby="notificationsDropdown">
                        <div class="dropdown-header">Notifications</div>
                        <div id="notifications-container-real-time-result">
                            @foreach (Auth::user()->notifications->take(5)->reverse() as $notification)
                                @switch($notification->data['notify_type'])
                                    @case('product')
                                        <a class="dropdown-item p-2"
                                            href="{{ route('products.edit', ['product' => $notification->data['product_id']]) }}">
                                            <div class="notification-item rounded bg-label-muted {{ $notification->read_at ? 'btn-outline-dark' : 'btn-outline-primary' }} p-2 "
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
                                    @break

                                    @case('order')
                                        <a class="dropdown-item p-2"
                                            href="{{ route('orders.edit', ['order' => $notification->data['order_id']]) }}">
                                            <div class="notification-item rounded bg-label-muted {{ $notification->read_at ? 'btn-outline-dark' : 'btn-outline-primary' }} p-2"
                                                id="notification-item">
                                                <div class="notification-avatar ">
                                                    {{ $notification->data['username'] }}
                                                </div>
                                                <div class="notification-content ">
                                                    {{ $notification->data['notify_type'] . ' ' . $notification->data['order_code'] . ' ' . $notification->data['action'] }}
                                                </div>
                                                <span class="text-muted">{{ \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans() }}</span>
                                            </div>
                                        </a>
                                    @break

                                    @case('user')
                                        <a class="dropdown-item p-2"
                                            href="{{ route('users.edit', ['user' => $notification->data['user_id']]) }}">
                                            <div class="notification-item rounded bg-label-muted {{ $notification->read_at ? 'btn-outline-dark' : 'btn-outline-primary' }} p-2"
                                                id="notification-item">
                                                <div class="notification-avatar ">
                                                    {{ $notification->data['user_name'] . ' ' . $notification->data['action'] }}
                                                </div>
                                                <span class="text-muted">{{ \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans() }}</span>
                                            </div>
                                        </a>
                                    @break

                                    @case('chat')
                                        <a class="dropdown-item p-2"
                                            href="{{ route('chats.show', [$notification->data['chat_id']]) }}">
                                            <div class="notification-item rounded bg-label-muted {{ $notification->read_at ? 'btn-outline-dark' : 'btn-outline-primary' }} p-2"
                                                id="notification-item">

                                                <div class="notification-avatar ">
                                                    {{ $notification->data['username'] }}
                                                </div>
                                                <div class="notification-content ml-1 text-muted">
                                                    {{ $notification->data['message'] }}
                                                </div>
                                                <span class="text-muted">{{ \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans() }}</span>
                                            </div>
                                        </a>
                                    @break

                                    @default
                                @endswitch
                            @endforeach
                        </div>
                        <div id="notification-holder-message" class="text-center text-muted">
                            @if (!Auth::user()->notifications->count())
                                <span class="dropdown-item">There Is No Notifications Yet</span>
                            @endif
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center {{Route::currentRouteNamed('notifications.all') ? 'active' : null}}" href="{{ route('notifications.all') }}">View All
                            Notifications</a>
                    </div>
                </li>


            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    {{-- <div class="avatar avatar-online">
                        @if (auth()->user()->image ?? null)
                            <img src="{{ asset('uploads/users/' . auth()->user()->image) }}" alt
                                class="w-px-40 h-auto rounded-circle" />
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.8 61.8" id="avatar">
                                <g data-name="Layer 2">
                                    <g data-name="—ÎÓÈ 1">
                                        <circle cx="30.9" cy="30.9" r="30.9" fill="#ffc200"></circle>
                                        <path fill="#677079" fill-rule="evenodd"
                                            d="M52.587 52.908a30.895 30.895 0 0 1-43.667-.291 9.206 9.206 0 0 1 4.037-4.832 19.799 19.799 0 0 1 4.075-2.322c-2.198-7.553 3.777-11.266 6.063-12.335 0 3.487 3.265 1.173 7.317 1.217 3.336.037 9.933 3.395 9.933-1.035 3.67 1.086 7.67 8.08 4.917 12.377a17.604 17.604 0 0 1 3.181 2.002 10.192 10.192 0 0 1 4.144 5.22z">
                                        </path>
                                        <path fill="#f9dca4" fill-rule="evenodd"
                                            d="m24.032 38.68 14.92.09v3.437l-.007.053a2.784 2.784 0 0 1-.07.462l-.05.341-.03.071c-.966 5.074-5.193 7.035-7.803 8.401-2.75-1.498-6.638-4.197-6.947-8.972l-.013-.059v-.2a8.897 8.897 0 0 1-.004-.207c0 .036.003.07.004.106z">
                                        </path>
                                        <path fill-rule="evenodd"
                                            d="M38.953 38.617v4.005a7.167 7.167 0 0 1-.095 1.108 6.01 6.01 0 0 1-.38 1.321c-5.184 3.915-13.444.704-14.763-5.983z"
                                            opacity=".11"></path>
                                        <path fill="#f9dca4" fill-rule="evenodd"
                                            d="M18.104 25.235c-4.94 1.27-.74 7.29 2.367 7.264a19.805 19.805 0 0 1-2.367-7.264zM43.837 25.235c4.94 1.27.74 7.29-2.368 7.263a19.8 19.8 0 0 0 2.368-7.263z">
                                        </path>
                                        <path fill="#ffe8be" fill-rule="evenodd"
                                            d="M30.733 11.361c20.523 0 12.525 32.446 0 32.446-11.83 0-20.523-32.446 0-32.446z">
                                        </path>
                                        <path fill="#8a5c42" fill-rule="evenodd"
                                            d="M21.047 22.105a1.738 1.738 0 0 1-.414 2.676c-1.45 1.193-1.503 5.353-1.503 5.353-.56-.556-.547-3.534-1.761-5.255s-2.032-13.763 4.757-18.142a4.266 4.266 0 0 0-.933 3.6s4.716-6.763 12.54-6.568a5.029 5.029 0 0 0-2.487 3.26s6.84-2.822 12.54.535a13.576 13.576 0 0 0-4.145 1.947c2.768.076 5.443.59 7.46 2.384a3.412 3.412 0 0 0-2.176 4.38c.856 3.503.936 6.762.107 8.514-.829 1.752-1.22.621-1.739 4.295a1.609 1.609 0 0 1-.77 1.214c-.02.266.382-3.756-.655-4.827-1.036-1.07-.385-2.385.029-3.163 2.89-5.427-5.765-7.886-10.496-7.88-4.103.005-14 1.87-10.354 7.677z">
                                        </path>
                                        <path fill="#434955" fill-rule="evenodd"
                                            d="M19.79 49.162c.03.038 10.418 13.483 22.63-.2-1.475 4.052-7.837 7.27-11.476 7.26-6.95-.02-10.796-5.6-11.154-7.06z">
                                        </path>
                                        <path fill="#e6e6e6" fill-rule="evenodd"
                                            d="M36.336 61.323c-.41.072-.822.135-1.237.192v-8.937a.576.576 0 0 1 .618-.516.576.576 0 0 1 .619.516v8.745zm-9.82.166q-.622-.089-1.237-.2v-8.711a.576.576 0 0 1 .618-.516.576.576 0 0 1 .62.516z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        @endif
                    </div> --}}
                    @auth
                        {{ auth()->user()->name }}
                    @endauth
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        @if (auth()->user()->image)
                                            <img src="{{ asset('uploads/users/' . auth()->user()->image) }}" alt
                                                class="w-px-40 h-auto  img-fluid" />
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.8 61.8"
                                                id="avatar">
                                                <g data-name="Layer 2">
                                                    <g data-name="—ÎÓÈ 1">
                                                        <circle cx="30.9" cy="30.9" r="30.9"
                                                            fill="#ffc200"></circle>
                                                        <path fill="#677079" fill-rule="evenodd"
                                                            d="M52.587 52.908a30.895 30.895 0 0 1-43.667-.291 9.206 9.206 0 0 1 4.037-4.832 19.799 19.799 0 0 1 4.075-2.322c-2.198-7.553 3.777-11.266 6.063-12.335 0 3.487 3.265 1.173 7.317 1.217 3.336.037 9.933 3.395 9.933-1.035 3.67 1.086 7.67 8.08 4.917 12.377a17.604 17.604 0 0 1 3.181 2.002 10.192 10.192 0 0 1 4.144 5.22z">
                                                        </path>
                                                        <path fill="#f9dca4" fill-rule="evenodd"
                                                            d="m24.032 38.68 14.92.09v3.437l-.007.053a2.784 2.784 0 0 1-.07.462l-.05.341-.03.071c-.966 5.074-5.193 7.035-7.803 8.401-2.75-1.498-6.638-4.197-6.947-8.972l-.013-.059v-.2a8.897 8.897 0 0 1-.004-.207c0 .036.003.07.004.106z">
                                                        </path>
                                                        <path fill-rule="evenodd"
                                                            d="M38.953 38.617v4.005a7.167 7.167 0 0 1-.095 1.108 6.01 6.01 0 0 1-.38 1.321c-5.184 3.915-13.444.704-14.763-5.983z"
                                                            opacity=".11"></path>
                                                        <path fill="#f9dca4" fill-rule="evenodd"
                                                            d="M18.104 25.235c-4.94 1.27-.74 7.29 2.367 7.264a19.805 19.805 0 0 1-2.367-7.264zM43.837 25.235c4.94 1.27.74 7.29-2.368 7.263a19.8 19.8 0 0 0 2.368-7.263z">
                                                        </path>
                                                        <path fill="#ffe8be" fill-rule="evenodd"
                                                            d="M30.733 11.361c20.523 0 12.525 32.446 0 32.446-11.83 0-20.523-32.446 0-32.446z">
                                                        </path>
                                                        <path fill="#8a5c42" fill-rule="evenodd"
                                                            d="M21.047 22.105a1.738 1.738 0 0 1-.414 2.676c-1.45 1.193-1.503 5.353-1.503 5.353-.56-.556-.547-3.534-1.761-5.255s-2.032-13.763 4.757-18.142a4.266 4.266 0 0 0-.933 3.6s4.716-6.763 12.54-6.568a5.029 5.029 0 0 0-2.487 3.26s6.84-2.822 12.54.535a13.576 13.576 0 0 0-4.145 1.947c2.768.076 5.443.59 7.46 2.384a3.412 3.412 0 0 0-2.176 4.38c.856 3.503.936 6.762.107 8.514-.829 1.752-1.22.621-1.739 4.295a1.609 1.609 0 0 1-.77 1.214c-.02.266.382-3.756-.655-4.827-1.036-1.07-.385-2.385.029-3.163 2.89-5.427-5.765-7.886-10.496-7.88-4.103.005-14 1.87-10.354 7.677z">
                                                        </path>
                                                        <path fill="#434955" fill-rule="evenodd"
                                                            d="M19.79 49.162c.03.038 10.418 13.483 22.63-.2-1.475 4.052-7.837 7.27-11.476 7.26-6.95-.02-10.796-5.6-11.154-7.06z">
                                                        </path>
                                                        <path fill="#e6e6e6" fill-rule="evenodd"
                                                            d="M36.336 61.323c-.41.072-.822.135-1.237.192v-8.937a.576.576 0 0 1 .618-.516.576.576 0 0 1 .619.516v8.745zm-9.82.166q-.622-.089-1.237-.2v-8.711a.576.576 0 0 1 .618-.516.576.576 0 0 1 .62.516z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">
                                        @auth
                                            {{ auth()->user()->name }}
                                        @endauth
                                    </span>
                                    <small class="text-muted">
                                        @auth
                                            {{ auth()->user()->email }}
                                        @endauth
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item {{ Route::currentRouteNamed('profile.edit') ? 'active' : null }}" href="{{ route('profile.edit') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('home.show') }}">
                            <i class='bx bxs-store'></i>
                            <span class="align-middle mx-2"> WebSite</span>
                        </a>
                    </li>
                    @can('settings edit')
                        <li>
                            <a class="dropdown-item {{ Route::currentRouteNamed('settings.all') ? 'active' : null }}" href="{{ route('settings.all') }}">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Settings</span>
                            </a>
                        </li>
                    @endcan
                    {{-- <li>
          <a class="dropdown-item" href="#">
            <span class="d-flex align-items-center align-middle">
              <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
              <span class="flex-grow-1 align-middle">Billing</span>
              <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
            </span>
          </a>
        </li>
        <li> --}}
                    <div class="dropdown-divider"></div>
            </li>
            <li>
                <a class="dropdown-item" href="auth-login-basic.html"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="bx bx-power-off me-2"></i>
                    <span class="align-middle">Log Out</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                </form>
            </li>
        </ul>
        </li>
        <!--/ User -->
        </ul>
    </div>
</nav>
