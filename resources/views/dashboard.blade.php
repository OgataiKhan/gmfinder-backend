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

                        {{ __('You are logged in!') }}
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('game_master.index') }}" class="btn btn-primary">View your profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
