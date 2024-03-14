<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GM Finder') }}</title>
    <link rel="icon" href="{{ asset('img/favicon.png') }}">

    <!-- Fontawesome 6 cdn -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'
        integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=='
        crossorigin='anonymous' referrerpolicy='no-referrer' />

    {{-- my CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin-layout.css') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- use stylesheet in view --}}
    @stack('styles')

    <!-- Vite -->
    @vite(['resources/js/app.js'])

    {{-- jQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div id="app">
        {{-- HEADER --}}
        <header class="header">
            <div class="container d-flex justify-content-between align-items-center">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg text-center flex-grow-1">
                    <div class="container-fluid">
                        <!-- logo -->
                        <div class="logo pt-2">
                            <a class="text-decoration-none" href="{{ env('FRONTEND_URL') }}">
                                <img src="/img/logo.png" alt="logo" /></a>
                        </div>
                        <!-- /logo -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" id="header-button"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-md-0 gap-3">
                                <li class="nav-item items">
                                    <a class="nav-link link" href="{{ env('FRONTEND_URL') }}">Home</a>
                                </li>
                                <li class="nav-item items">
                                    <a class="nav-link link">FAQ</a>
                                </li>
                                <li class="nav-item items">
                                    <a class="nav-link link">Contact Us</a>
                                </li>
                                <li>
                                    <a class="header-button btn" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                                        {{ __('Sign Out') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- /navbar -->
            </div>
        </header>
        <div class="container-fluid">
            <div class="row h-100">
                <button id="show-sidebar-mobile-btn"
                    class="navbar-toggler position-absolute d-md-none collapsed text-white" type="button"
                    data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span
                        class="navbar-toggler-icon panel-title text-black w-100 d-flex justify-content-center align-items-center"></span>
                </button>
                {{-- Sidebar --}}
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block navbar-dark sidebar collapse">
                    <div class="position-sticky pt-3 sidebarMenuBox">
                        <ul class="nav flex-column">
                            @if (Auth::user() && Auth::user()->gameMaster && Auth::user()->gameMaster->is_active)
                                <li class="nav-item">
                                    <a class="nav-link text-center text-md-start"
                                        href="{{ route('game_master.index') }}">
                                        <i class="fa-solid fa-user fa-lg fa-fw"></i></i> Profile
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                @if (auth()->user() && auth()->user()->gameMaster()->exists())
                                    <a class="nav-link text-center text-md-start"
                                        href="{{ route('game_master.edit', 'game_master') }}">
                                        <i class="fa-solid fa-pen-to-square fa-lg fa-fw"></i> Edit Profile
                                    </a>
                                @else
                                    <a class="nav-link text-center text-md-start"
                                        href="{{ route('game_master.create') }}">
                                        <i class="fa-solid fa-wand-magic-sparkles fa-lg fa-fw"></i> Create Profile
                                    </a>
                                @endif
                            </li>
                            @if (Auth::user() && Auth::user()->gameMaster && Auth::user()->gameMaster->is_active)
                                <li class="nav-item">
                                    <a class="nav-link text-center text-md-start" href="{{ route('messages') }}">
                                        <i class="fa-solid fa-inbox fa-lg fa-fw"></i></i> Inbox
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center text-md-start" href="{{ route('reviews') }}">
                                        <i class="fa-solid fa-star fa-lg fa-fw"></i> My Reviews
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center text-md-start"
                                        href="{{ route('promotions.create') }}">
                                        <i class="fa-solid fa-rocket fa-lg fa-fw"></i> Promotions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center text-md-start" href="{{ route('stats') }}">
                                        <i class="fa-solid fa-square-poll-vertical fa-lg fa-fw"></i> My Stats
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </nav>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 section-main" id="main">
                    @yield('content')
                </main>
            </div>
        </div>
        {{-- FOOTER --}}
        <footer id="footer">
            <div class="container">
                <div class="row d-flex">
                    <!-- left col -->
                    <div class="col col-md-6 d-flex justify-content-between order-2 order-md-1 d-none d-md-flex">
                        <!-- link -->
                        <div class="col col-md-4 p-3">
                            <h5 class="text-uppercase mb-3">About</h5>
                            <ul>
                                <li>
                                    <a href="#">About Us</a>
                                </li>
                                <li>
                                    <a href="#">Contact Us</a>
                                </li>
                                <li>
                                    <a href="#">FAQs</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col p-3 col-md-4">
                            <h5 class="text-uppercase mb-3">Community
                            </h5>
                            <ul>
                                <li>
                                    <a href="#">Events</a>
                                </li>
                                <li>
                                    <a href="#">Forums</a>
                                </li>
                                <a href="#">Guides</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col p-3 col-md-4">
                            <h5 class="text-uppercase mb-3">Legal
                            </h5>
                            <ul>
                                <li>
                                    <a href="#">Service</a>
                                </li>
                                <li>
                                    <a href="#">Privacy</a>
                                </li>
                                <li>
                                    <a href="#">Accessibility</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /link -->
                    </div>
                    <!-- /left col -->
                    <!-- right col -->
                    <div class="d-flex flex-column col order-1">
                        <div>
                            <!-- newsletter e button -->
                            <form>
                                <div class="text-center text-lg-start">
                                    <h3>Newsletter</h3>
                                </div>
                                <div class="d-lg-flex">
                                    <div
                                        class="py-2 d-flex justify-content-center justify-content-lg-start  flex-grow-1">
                                        <input type="email"
                                            class="form-control news-email input-focus-orange me-lg-3" id="inputEmail"
                                            placeholder="Your Email Address" />
                                    </div>
                                    <div
                                        class="d-flex justify-content-center justify-content-lg-start align-items-center">
                                        <button type="submit" class="btn-sm btn-orange mb-3 mb-lg-0">
                                            <strong>Subscribe</strong>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- /newsletter e button -->
                        </div>
                        <!-- icons -->
                        <div class="mt-3 d-flex justify-content-center justify-content-lg-start">
                            <ul class="d-flex gap-4">
                                <li>
                                    <a href="#" class="link"><i class="bi bi-instagram fs-3"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="link"><i class="bi bi-twitter-x fs-3"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="link"><i class="bi bi-facebook fs-3"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="link"><i class="bi bi-tiktok fs-3"></i></a>
                                </li>
                            </ul>
                        </div>
                        <!-- /icons -->
                    </div>
                    <!-- /right col -->
                </div>
                <hr />
            </div>
            <div class="container d-flex justify-content-between align-items-center">
                <div class="logo">
                    <img src="/img/logo.png" alt="logo" />
                </div>
                <div>
                    <a href="#">
                        <button class="btn-orange">
                            <span class="arrow-up"><strong>Back To Top</strong></span>
                        </button>
                    </a>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
