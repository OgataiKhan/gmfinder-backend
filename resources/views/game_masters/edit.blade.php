@extends('layouts.admin')
@section('content')
    <div class="container">

        {{-- <h2 class="text-center">Edit Your Info</h2> --}}

        <form id="gm-create-form" action={{ route('game_master.update', 'game_master') }} method="POST"
            class="d-flex row p-4 my-5 col-8 mx-auto" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="d-flex justify-content-between">

                {{-- Location --}}
                <div class="col-6 mb-3">
                    <label for="location" class="form-label required">Location</label>
                    <select class="input-focus-orange form-select {{ $errors->has('location') ? 'is-invalid' : '' }}"
                        name="location" id="location" required>
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
                    <label for="max_players" class="form-label required">Max Players</label>
                    <input type="number"
                        class="input-focus-orange form-control {{ $errors->has('max_players') ? 'is-invalid' : '' }}"
                        id="max_players" name="max_players" value="{{ old('max_players', $game_master->max_players) }}"
                        required min="1" max="127">
                    @if ($errors->has('max_players'))
                        <div class="invalid-feedback">
                            {{ $errors->first('max_players') }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Game Description --}}
            <div class="mb-3">
                <label for="game_description required" class="form-label">Game description</label>
                <textarea class="input-focus-orange form-control {{ $errors->has('game_description') ? 'is-invalid' : '' }}"
                    name="game_description" id="game_description" rows="3" required maxlength="1000">{{ old('game_description', $game_master->game_description) }}</textarea>
                @if ($errors->has('game_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('game_description') }}
                    </div>
                @endif
            </div>

            {{-- Game Systems --}}
            <div class="mb-3">
                <div class="d-flex">
                    <p class="form-label required">Game systems</p>
                    <p class="ms-4 d-none text-danger" id="no-checkboxes">Please select at least one game system</p>
                </div>
                @foreach ($game_systems as $game_system)
                    <div class="form-check">
                        @if ($errors->any())
                            <input name="game_systems[]" class="input-focus-orange form-check-input checked-orange"
                                id="game_system-{{ $game_system->id }}" type="checkbox" value="{{ $game_system->id }}"
                                {{ in_array($game_system->id, old('game_systems', [])) ? 'checked' : '' }}>
                        @else
                            <input name="game_systems[]" class="input-focus-orange form-check-input checked-orange"
                                id="game_system-{{ $game_system->id }}" type="checkbox" value="{{ $game_system->id }}"
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
                    id="profile_img" name="profile_img" maxlength="2048">
                @if ($errors->has('profile_img'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profile_img') }}
                    </div>
                @endif
            </div>
            <div class="mb-3 col">
                <input type="hidden" name="is_available" value="0"> <!-- Hidden input with value 0 -->
                <input
                    class="{{ $errors->has('is_available') ? 'is-invalid' : '' }} input-focus-orange form-check-input checked-orange"
                    type="checkbox" id="toggleIsAvailable" name="is_available" value="1"
                    {{ $game_master->is_available ? 'checked' : '' }}>
                <label for="toggleIsAvailable">Ready for a new game session ?</label>
                <div class="invalid-feedback">
                    {{ $errors->first('is_available') }}
                </div>
            </div>
            <div class="d-flex">
                <button id="create-button" type="submit" class="btn btn-void-orange mx-auto">Seems good!</button>
            </div>
        </form>
    </div>
    @vite(['resources/js/checkboxValidation.js'])
@endsection

@push('styles')
    <link href="{{ asset('css/gm-edit.css') }}" rel="stylesheet">
@endpush
