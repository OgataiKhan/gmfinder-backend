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

                {{-- Location --}}
                <div class="col-6 mb-3">
                    <label for="location" class="form-label">Location</label>
                    <select class="form-select {{ $errors->has('location') ? 'is-invalid' : '' }}" name="location"
                        id="location">
                        <option value="" disabled selected hidden>Select a province</option>
                        @foreach ($province as $single_province)
                            <option value="{{ $single_province }}" @if (old('location') == $single_province || ($game_master && $game_master->location == $single_province)) selected @endif>
                                {{ $single_province }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('location'))
                        <div class="invalid-feedback">
                            {{ $errors->first('location') }}
                        </div>
                    @endif
                </div>

                {{-- Max Players --}}
                <div class="mb-3 col-6 ms-1">
                    <label for="max_players" class="form-label">Max Players</label>
                    <input type="number" class="form-control {{ $errors->has('max_players') ? 'is-invalid' : '' }}"
                        id="max_players" name="max_players" value="{{ old('max_players', $game_master->max_players) }}">
                    @if ($errors->has('max_players'))
                        <div class="invalid-feedback">
                            {{ $errors->first('max_players') }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Game Description --}}
            <div class="mb-3">
                <label for="game_description" class="form-label">Game description</label>
                <textarea class="form-control {{ $errors->has('game_description') ? 'is-invalid' : '' }}" name="game_description"
                    id="game_description" rows="3">{{ old('game_description', $game_master->game_description) }}</textarea>
                @if ($errors->has('game_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('game_description') }}
                    </div>
                @endif
            </div>

            {{-- Game Systems --}}
            <div class="mb-3">
                <p class="form-label">Game systems</p>
                @foreach ($game_systems as $game_system)
                    <div class="form-check">
                        @if ($errors->any())
                            <input name="game_systems[]" class="form-check-input" id="game_system-{{ $game_system->id }}"
                                type="checkbox" value="{{ $game_system->id }}"
                                {{ in_array($game_system->id, old('game_systems', [])) ? 'checked' : '' }}>
                        @else
                            <input name="game_systems[]" class="form-check-input" id="game_system-{{ $game_system->id }}"
                                type="checkbox" value="{{ $game_system->id }}"
                                {{ $game_master->gameSystems->contains($game_system->id) ? 'checked' : '' }}>
                        @endif
                        <label class="form-check-label"
                            for="game_system-{{ $game_system->id }}">{{ $game_system->name }}</label>
                    </div>
                @endforeach
                @if ($errors->has('game_systems'))
                    <div class="text-danger">
                        {{ $errors->first('game_systems') }}
                    </div>
                @endif
            </div>

            {{-- Profile Picture --}}
            <div class="mb-3 col-12">
                <label for="profile_img" class="form-label">Choose a profile picture</label>
                <input class="form-control {{ $errors->has('profile_img') ? 'is-invalid' : '' }}" type="file"
                    id="profile_img" name="profile_img">
                @if ($errors->has('profile_img'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profile_img') }}
                    </div>
                @endif
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
