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
    <link rel="stylesheet" href="{{ asset('css/app-layout.css') }}">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/js/app.js'])

    {{-- use stylesheet in view --}}
    @stack('styles')
</head>

<body>
    <div id="app">
        <header>
            <div class="container d-flex justify-content-between align-items-center">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg text-center flex-grow-1">
                    <div class="container-fluid">
                        <!-- logo -->
                        <div class="logo pt-2">
                            <router-link :to="{ name: 'home' }" class="text-decoration-none">
                                <img src="/img/logo.png" alt="logo" />
                            </router-link>
                        </div>
                        <!-- /logo -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" id="header-button"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-md-0 gap-3">
                                <li class="nav-item">
                                    <a href="http://localhost:5173" class="nav-link">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link">FAQ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link">Contact Us</a>
                                </li>
                                @guest
                                    <li>
                                        <a class="header-button btn w-100"
                                            href="{{ route('login') }}">{{ __('Sign In') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li>
                                            <a class="btn header-button w-100"
                                                href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item"
                                                href="{{ url('dashboard') }}">{{ __('Dashboard') }}</a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                                {{ __('Sign Out') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- /navbar -->
            </div>
        </header>
        <main class="section-main">
            @yield('content')
        </main>
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
                                        <input type="email" class="form-control news-email input-focus-orange me-lg-3"
                                            id="inputEmail" placeholder="Your Email Address" />
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
        </footer>
    </div>
</body>

</html>
