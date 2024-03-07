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
                <nav class="navbar navbar-expand-md text-center flex-grow-1">
                    <div class="container-fluid">
                        <!-- logo -->
                        <div class="logo">
                            <router-link :to="{ name: 'home' }" class="text-decoration-none">
                                <img src="/img/logo.png"
                                    alt="logo" /></router-link>
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
                                    <router-link :to="{ name: 'home' }" class="nav-link">Home</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{ name: 'home' }" class="nav-link">Games</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{ name: 'home' }" class="nav-link">FAQ</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{ name: 'home' }" class="nav-link">Contact</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{ name: 'advanced-search' }" class="nav-link">Search</router-link>
                                </li>
                                @guest
                                    <li>
                                        <a class="header-button btn w-100"
                                            href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li>
                                            <a class="btn header-button w-100"
                                                href="{{ route('register') }}">{{ __('Register') }}</a>
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
                                                {{ __('Logout') }}
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
                        <div class="d-flex align-items-center justify-content-end">
                            <!-- newsletter & button -->
                            <form class="row g-3">
                                <div class="col-auto">
                                    <h3>Newsletter</h3>
                                </div>
                                <div class="col-auto">
                                    <label for="inputEmail" class="visually-hidden">Password</label>
                                    <input type="email" class="form-control" id="inputEmail"
                                        placeholder="Your Email Address">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-orange mb-3">Subscribe</button>
                                </div>
                            </form>
                            {{-- </form> --}}
                            <!-- /newsletter & button -->
                        </div>
                        <!-- icons -->
                        <div class="mt-3">
                            <ul class="d-flex gap-3 justify-content-end">
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
                        <button type="reset" class="btn btn-orange">
                            Back to Top
                        </button>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
