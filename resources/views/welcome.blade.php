@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'GM Finder') }}</title>
    <link rel="icon" href="{{ asset('img/favicon.png') }}">

    <!-- Fontawesome 6 cdn -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'
        integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=='
        crossorigin='anonymous' referrerpolicy='no-referrer' />

    {{-- my CSS --}}
    <link rel="stylesheet" href="{{ asset('css/welcome-layout.css') }}">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/js/app.js'])

</head>

<body>
    @section('content')
        <div class="py-5 container-jumbo">
            <div>
                <div class="container flex-column d-flex align-items-center my-5">
                    <a href="{{ env('FRONTEND_URL') }}"><img class="img" src="./img/logo.png" alt="welcome-logo"></a>
                    {{-- <div class="container-title py-3 px-4 mt-3">
                        <h2 class="fw-bold text-center text-black">
                            Welcome to GM Finder
                        </h2>
                    </div> --}}
                </div>
            </div>
        </div>
    @endsection
</body>

</html>
