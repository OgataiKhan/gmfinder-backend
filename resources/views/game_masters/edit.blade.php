@extends('layouts.admin')
@section('content')
    <div class="container">

        <h2 class="text-center">Edit Your Character</h2>

        <form action={{ route('game_master.update', 'game_master') }} method="POST" class="d-flex row p-4

        "
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="d-flex justify-content-between">
                <div class="col-6 mb-3">
                    <label for="location" class="form-label">Location</label>
                    <select class="form-select" name="location" id="location">
                        <option value="" disabled selected hidden>Select a province</option>
                        @foreach ($province as $single_province)
                            <option value="{{ $single_province }}" @if (old('location') == $single_province || ($game_master && $game_master->location == $single_province)) selected @endif>
                                {{ $single_province }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-6 ms-1">
                    <label for="max_players" class="form-label">Max Players</label>
                    <input type="number" class="form-control" id="max_players" name="max_players"
                        value="{{ old('max_players', $game_master->max_players) }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="game_description" class="form-label">Game description</label>
                <textarea class="form-control" name="game_description" id="game_description" rows="3">{{ old('game_description', $game_master->game_description) }}</textarea>
            </div>
            <div class="mb-3">
                {{-- @dd($game_systems) --}}
                <p class="form-label">Game systems</p>
                @foreach ($game_systems as $game_system)
                    <div class="form-check">
                        <input name="game_systems[]" class="form-check-input" id="game_system-{{ $game_system->id }}"
                            type="checkbox" value="{{ $game_system->id }}"
                            {{ $game_master->gameSystems->contains($game_system->id) ||
                            in_array($game_system->id, (array) old('game_systems', []))
                                ? 'checked'
                                : '' }}>
                        <label class="form-check-label"
                            for="game_system-{{ $game_system->id }}">{{ $game_system->name }}</label>
                    </div>
                @endforeach

            </div>
            <div class="mb-3 col-12">
                <label for="profile_img" class="form-label">Choose a profile picture</label>
                <input class="form-control" type="file" id="profile_img" name="profile_img">
            </div>
            <div class="d-flex">
                <button id="create-button" type="submit" class="btn btn-primary mx-auto">Edit</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('css/gm-create.css') }}" rel="stylesheet">
@endpush
