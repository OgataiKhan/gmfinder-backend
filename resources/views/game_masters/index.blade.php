@extends('layouts.admin')
@section('content')
    <div class="container py-4">
        @if ($user && $user->gameMaster && $user->gameMaster->is_active)
            <div class="card" id="gm-card">
                {{-- show user info --}}
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3>{{ $user->name }} @if ($user->gameMaster->has_active_promotion)
                                <i class="bi bi-stars"></i>
                            @endif
                        </h3>
                        <div>
                            <a href="{{ $url }}" class="btn btn-void-orange">Show Public
                                Profile</a>
                        </div>
                    </div>
                </div>
                {{-- show game master info --}}
                @if ($user->gameMaster)
                    <div class="card-body" id="gm-card-body">
                        <div class="d-flex flex-column justify-content-between flex-lg-row justify-content-lg-between">
                            <div class="gm-info order-2 order-lg-1 pt-3 pt-lg-0 col-lg-6">
                                <p> <strong>Game Description: </strong> {{ $user->gameMaster->game_description }}</p>
                                <p> <strong>Game Systems: </strong>
                                    @foreach ($user->gameMaster->gameSystems as $game_system)
                                        <li>{{ $game_system->name }}</li>
                                    @endforeach
                                </p>
                                <p> <strong>Max Players: </strong> {{ $user->gameMaster->max_players }}</p>
                                <p> <strong>Email: </strong> {{ $user->email }}</p>
                                <p>
                                <p> <strong>Location: </strong> {{ $user->gameMaster->location }}</p>
                                <p>
                                    <strong>Availability: </strong>
                                    {!! $user->gameMaster->is_available
                                        ? 'Available <span style="color:green;">●</span>'
                                        : 'Not Available <span style="color:red;">●</span>' !!}
                                </p>
                                @if ($user->gameMaster->has_active_promotion)
                                    <p><strong>Promotion Ends On:
                                        </strong>{{ \Carbon\Carbon::parse($user->gameMaster->latest_promotion_end_time)->format('d M Y') }}
                                    </p>
                                @endif
                                {{-- button to show profile, edit and delete --}}
                                <div class="d-flex">
                                    {{-- edit profile --}}
                                    <a href="{{ route('game_master.edit', $user) }}"
                                        class="btn btn-void-orange align-self-center me-2">Edit</a>
                                    {{-- delete profile --}}
                                    <button type="button" class="btn btn-danger-custom" data-bs-toggle="modal"
                                        data-bs-target="#deleteConfirmationModal-{{ $user->id }}">
                                        Delete
                                    </button>
                                </div>
                            </div>
                            {{-- profile picture --}}
                            <div id="gm-pic" class="order-1 mx-auto mx-lg-0">
                                @if ($user->gameMaster->profile_img)
                                    {{-- show image --}}
                                    <img src="{{ asset('storage/' . $user->gameMaster->profile_img) }}"
                                        alt="Game Master Pic">
                                @else
                                    <img src="/img/generic-avatar.webp" alt="Generic GM Avatar" /></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Delete confirmation modal --}}
                    <div class="modal fade" id="deleteConfirmationModal-{{ $user->id }}" tabindex="-1"
                        aria-labelledby="deleteConfirmationModalLabel-{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteConfirmationModalLabel-{{ $user->id }}">We are
                                        sad to see you go!</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    This action is irreversible. Are you sure you want to delete your account?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn-void-orange" data-bs-dismiss="modal">Cancel</button>
                                    <form method="POST"
                                        action="{{ route('game_master.destroy', $user->gameMaster->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-custom">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            {{-- account deleted --}}
            <div class="alert p-3 d-flex flex-column align-items-center border border-2">
                <p>Create a Game Master profile to begin your adventure!</p>
                {{-- <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-void-orange">Home Page</button>
                </form> --}}
                <a href="{{ route('game_master.create') }}" class="btn btn-void-orange">Create Profile</a>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <link href="{{ asset('css/gm-index.css') }}" rel="stylesheet">
@endpush
