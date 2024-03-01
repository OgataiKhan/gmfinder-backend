@extends('layouts.admin')
@section('content')
    <div class="container py-4">
        <div class="card">
            {{-- show user info --}}
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <p>{{ $user->name }}</p>
                    {{-- edit profile --}}
                    <a href="{{ route('game_master.edit', $user) }}" class="btn btn-success btn-sm align-self-center">Edit</a>
                </div>
                <p>{{ $user->email }}</p>
            </div>
            {{-- show game master info --}}
            @if ($user->gameMaster)
                <div class="card-body">
                    Here's my game master info
                </div>
            @endif
        </div>

    </div>
@endsection
