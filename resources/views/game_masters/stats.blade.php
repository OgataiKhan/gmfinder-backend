@extends('layouts.admin')
@section('content')
    <div class="container my-4">
        @if (Auth::user() && Auth::user()->gameMaster && Auth::user()->gameMaster->is_active)
            <h2>
                See your stats
            </h2>
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
@endsection

@push('styles')
    <link href="{{ asset('css/gm-stats.css') }}" rel="stylesheet">
@endpush
