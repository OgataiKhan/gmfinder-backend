@extends('layouts.admin')
@section('content')
    <div class="container my-5 text-center">
        <h1 class="my-5">Your payment has been processed succesfully!</h1>
        <h2 class="my-5">Enjoy your time as a sponsored Game Master</h2>
        <div class="container-img">
            <img class="img" src="/img/approved-icons.jpg" alt="">
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('css/gm-promotions.css') }}" rel="stylesheet">
@endpush
