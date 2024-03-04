@extends('layouts.admin')
@section('content')
    <div class="container py-4">
        @if ($user->gameMaster->is_active)
            <div class="card">
                {{-- show user info --}}
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p>{{ $user->name }}</p>
                        <div class="d-flex">
                            {{-- edit profile --}}
                            <a href="{{ route('game_master.edit', $user) }}"
                                class="btn btn-success btn-sm align-self-center">Edit</a>
                            {{-- delete profile --}}
                            <form action="{{ route('game_master.destroy', $user) }}" method="POST" class="d-flex">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm align-self-center">Delete</button>
                            </form>
                        </div>
                    </div>
                    <p>{{ $user->email }}</p>
                </div>
                {{-- show game master info --}}
                @if ($user->gameMaster)
                    <div class="card-body">
                        Here's my game master info
                    </div>
                    <div>

                        {{-- show image --}}
                        @if ($user->gameMaster->profile_img)
                            <img src="{{ asset('storage/' . $user->gameMaster->profile_img) }}" alt="Game Master Pic">
                        @else
                            <img src="https://icons.veryicon.com/png/o/miscellaneous/xdh-font-graphics-library/anonymous-user.png"
                                alt="Game Master Pic">
                        @endif
                    </div>
                @endif
            </div>
        @else
            {{-- account deleted --}}
            <div class="alert p-3 d-flex flex-column align-items-center border border-2">
                <p>Your account has been deleted.</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary btn-sm">Home Page</button>
                </form>
            </div>
        @endif
    </div>
@endsection
