@extends('layouts.admin')
@section('content')
    <div class="container py-5">
        @if (Auth::user() && Auth::user()->gameMaster && Auth::user()->gameMaster->is_active)
            <h3>
                See your stats
            </h3>

            <!-- Month Selectors -->
            <div>
                <label for="start_month">Start Month:</label>
                <input type="month" id="start_month" name="start_month">

                <label for="end_month">End Month:</label>
                <input type="month" id="end_month" name="end_month">
            </div>

            <!-- Placeholders for Data -->
            <div class="py-5">
                <p id="reviews_count">Reviews: 0</p>
                <p id="messages_count">Messages: 0</p>
            </div>

            <!-- Chart for Ratings Distribution -->
            <div>
                <canvas id="ratingsChart"></canvas>
            </div>
        @else
            <div class="alert p-3 d-flex flex-column align-items-center border border-2">
                <p>Create a Game Master profile to begin your adventure!</p>
                <a href="{{ route('game_master.create') }}" class="btn btn-void-orange">Create Profile</a>
            </div>
        @endif
    </div>

    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif

    @if (session('error_message'))
        <div class="alert alert-danger">
            {{ session('error_message') }}
        </div>
    @endif
    </div>
    @vite(['resources/js/dynamicStats.js'])
@endsection

@push('styles')
    <link href="{{ asset('css/gm-stats.css') }}" rel="stylesheet">
@endpush
