@extends('layouts.admin')
@section('content')
    <div class="container py-5">
        @if (Auth::user() && Auth::user()->gameMaster && Auth::user()->gameMaster->is_active)
            <h3 class="text-center">
                See your stats
            </h3>

            <!-- Month Selectors -->
            <div class="month-picker-container mb-5">
                <label for="start_month">Start Month:</label>
                <input type="month" id="start_month" name="start_month">

                <label for="end_month">End Month:</label>
                <input type="month" id="end_month" name="end_month">
            </div>

            <!-- Chart for Messages Distribution -->
            <h4>Messages you received in the selected time period</h4>
            <div class="graph-box pb-4">
                <canvas id="messagesChart" width="200" height="100"></canvas>
            </div>

            <!-- Chart for Reviews Distribution -->
            <h4>Reviews you received in the selected time period</h4>
            <div class="graph-box pb-4">
                <canvas id="reviewsChart" width="200" height="100"></canvas>
            </div>

            <!-- Chart for Ratings Distribution -->
            <h4>Ratings distribution in the selected time period</h4>
            <div class="graph-box pb-4">
                <canvas id="ratingsChart" width="200" height="100"></canvas>
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
