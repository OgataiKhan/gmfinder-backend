@extends('layouts.admin')

@section('content')
    <div class="container" id="dashboard-container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- {{ __('You are logged in!') }} --}}
                        <p class="text-center mt-4">Welcome back, <span class="fw-bold">{{ Auth::user()->name }}</span>. New
                            adventures await!</p>
                    </div>
                    <div class="card-body mb-2 text-center">
                        <a href="{{ route('game_master.index') }}" class="btn btn-void-orange">View your profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
