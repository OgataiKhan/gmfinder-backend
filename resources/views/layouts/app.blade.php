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
    <link rel="stylesheet" href="{{ asset('css/app-layout.css') }}">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])

    {{-- use stylesheet in view --}}
    @stack('styles')
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
                        @guest
                            <li>
                                <a class="btn" id="header-button" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li>
                                    <a class="btn" id="header-button"
                                        href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('dashboard') }}">{{ __('Dashboard') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </nav>
                <!-- /navbar -->
            </div>
        </header>

        <main id="main">
            @yield('content')
        </main>
        <footer id="footer">
            <div class="container py-2">
                <div class="row align-items-center">
                    <!-- col di sinistra -->
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
                    <!-- /col di sinistra -->

                    <!-- col di destra -->
                    <div class="col-6 ps-5">
                        <div class="d-flex align-items-center">
                            <!-- newsletter e button -->
                            <form class="d-flex justify-content-center gap-3" id="newsletter">
                                <div id="email">
                                    <label for="exampleFormControlInput1" class="form-label">Newsletter</label>
                                    <input type="email" class="form-control  me-5 email" id="exampleFormControlInput1"
                                        placeholder="email address" />
                                </div>
                                <div class="mt-4 button">
                                    <button type="submit" class="btn mt-2" id="footer-button">
                                        Subscribe
                                    </button>
                                </div>
                            </form>
                            <!-- /newsletter e button -->
                        </div>
                        <!-- icons -->
                        <div class="mt-3" id="newsletter">
                            <ul class="d-flex gap-3">
                                <li><a href="#">icons</a></li>
                                <li><a href="#">icons</a></li>
                                <li><a href="#">icons</a></li>
                                <li><a href="#">icons</a></li>
                            </ul>
                        </div>
                        <!-- /icons -->
                    </div>
                    <!-- /col di destra -->
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
