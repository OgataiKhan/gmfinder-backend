<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GM Finder') }}</title>

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
</head>

<body>
    <div id="app">
        <header id="header">
            <div class="container d-flex justify-content-between align-items-center py-2">
                <!-- logo -->
                <div class="logo">
                    <a class="text-decoration-none" href="{{ env('FRONTEND_URL') }}">
                        <img src="/img/dungeons_and_dragons_logo_by_floodgrunt-d6my4z8.png" alt="" /></a>
                </div>
                <!-- /logo -->
                <button class="navbar-toggler position-absolute d-md-none collapsed text-white" type="button"
                    data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- navbar -->
                <nav class="navbar-link">
                    <ul class="d-flex align-items-center gap-3 mt-3">
                        <!-- link navbar -->
                        <li>
                            <a class="link" href="{{ env('FRONTEND_URL') }}"><strong>Home</strong></a>
                        </li>
                        <li>
                            <a class="link" href="#"><strong>Game
                                    Master</strong></a>
                        </li>
                        <li>
                            <a class="link" href="#"><strong>Message</strong></a>
                        </li>
                        <li>
                            <a class="link" href="#"><strong>Error</strong></a>
                        </li>
                        <li>
                            <a class="link"
                                href="{{ env('FRONTEND_URL') }}/advanced-search"><strong>Search</strong></a>
                        </li>
                        <li>
                            <a class="btn" id="header-button" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        <!-- /link navbar -->
                    </ul>
                </nav>
                <!-- /navbar -->
            </div>
        </header>
        <div class="container-fluid">
            <div class="row h-100">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block navbar-dark sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-center text-md-start" href="{{ route('dashboard') }}">
                                    <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center text-md-start" href="{{ route('game_master.index') }}">
                                    <i class="fa-solid fa-user fa-lg fa-fw"></i></i> Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                @if (auth()->user() && auth()->user()->gameMaster()->exists())
                                    <a class="nav-link text-center text-md-start"
                                        href="{{ route('game_master.edit', 'game_master') }}">
                                        <i class="fa-solid fa-pen-to-square fa-lg fa-fw"></i> Edit Profile
                                    </a>
                                @else
                                    <a class="nav-link text-center text-md-start"
                                        href="{{ route('game_master.create') }}">
                                        <i class="fa-solid fa-user"></i> Create Profile
                                    </a>
                                @endif
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center text-md-start" href="{{ route('dashboard') }}">
                                    <i class="fa-solid fa-inbox fa-lg fa-fw"></i></i> Inbox
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center text-md-start" href="{{ route('dashboard') }}">
                                    <i class="fa-solid fa-star fa-lg fa-fw"></i> My Reviews
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center text-md-start" href="{{ route('dashboard') }}">
                                    <i class="fa-solid fa-square-poll-vertical fa-lg fa-fw"></i> My Stats
                                </a>
                            </li>
                        </ul>


                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main">
                    @yield('content')
                </main>
            </div>
        </div>
        <footer id="footer">
            <div class="container py-2">
                <div class="row align-items-center">
                    <!-- left col -->
                    <div class="col-6 d-flex">
                        <!-- link -->
                        <div class="col-4">
                            <h4 class="text-uppercase mb-3">About</h4>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">FAQs</a></li>
                            </ul>
                        </div>
                        <div class="col-4">
                            <h4 class="text-uppercase mb-3">Community</h4>
                            <ul>
                                <li><a href="#">Events</a></li>
                                <li><a href="#">Forums</a></li>
                                <li><a href="#">Guides</a></li>
                            </ul>
                        </div>
                        <div class="col-4">
                            <h4 class="text-uppercase mb-3">Legal</h4>
                            <ul>
                                <li><a href="#">Terme of Service</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Accessibility</a></li>
                            </ul>
                        </div>
                        <!-- /link -->
                    </div>
                    <!-- /left col -->

                    <!-- right col -->
                    <div class="col-6 ps-5">
                        <div class="d-flex align-items-center">
                            <!-- newsletter & button -->
                            <form class="d-flex justify-content-center gap-3">
                                <div id="email">
                                    <label for="exampleFormControlInput1" class="form-label">Newsletter</label>
                                    <input type="email" class="form-control  me-5 email"
                                        id="exampleFormControlInput1" placeholder="email address" />
                                </div>
                                <div class="mt-4 button">
                                    <button type="submit" class="btn mt-2" id="footer-button">
                                        Subscribe
                                    </button>
                                </div>
                            </form>
                            <!-- /newsletter & button -->
                        </div>
                        <!-- icons -->
                        <div class="mt-3">
                            <ul class="d-flex gap-3">
                                <li><a href="#">icons</a></li>
                                <li><a href="#">icons</a></li>
                                <li><a href="#">icons</a></li>
                                <li><a href="#">icons</a></li>
                            </ul>
                        </div>
                        <!-- /icons -->
                    </div>
                    <!-- /right col -->
                </div>
                <hr />
                <div class="container d-flex justify-content-between align-items-center px-0 pt-2">
                    <div class="logo">
                        <img src="/img/dungeons_and_dragons_logo_by_floodgrunt-d6my4z8.png" alt="" />
                    </div>
                    <div>
                        <button type="reset" class="btn" id="footer-button">
                            Back to Top
                        </button>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
