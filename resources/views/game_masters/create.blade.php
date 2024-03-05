@extends('layouts.admin')
@section('content')
    <div class="container my-4">

        <h2 class="text-center">Craft Your Character</h2>

        <form action={{ route('game_master.store') }} method="POST" enctype="multipart/form-data" id="gm-create-form"
            class="row flex-column col col-md-8 mx-auto mt-5">
            @csrf
            <div class="d-flex justify-content-between">
                {{-- Location --}}
                <div class="col-6 mb-3">
                    <label for="location" class="form-label required">Location</label>
                    <select class="input-focus-orange form-select {{ $errors->has('location') ? 'is-invalid' : '' }}"
                        name="location" id="location" required>
                        <option value="" disabled selected hidden>Select a province</option>
                        @foreach ($province as $single_province)
                            <option value="{{ $single_province }}" @if (old('location') == $single_province) selected @endif>
                                {{ $single_province }}</option>
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
                        id="max_players" name="max_players" value="{{ old('max_players') }}" required min="1"
                        max="127">
                    @if ($errors->has('max_players'))
                        <div class="invalid-feedback">
                            {{ $errors->first('max_players') }}
                        </div>
                    @endif
                </div>
            </div>
            {{-- Game Description --}}
            <div class="mb-3">
                <label for="game_description" class="form-label required">Game description</label>
                <textarea class="input-focus-orange form-control {{ $errors->has('game_description') ? 'is-invalid' : '' }}"
                    name="game_description" id="game_description" rows="3" required maxlength="1000">{{ old('game_description') }}</textarea>
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
                        <input name="game_systems[]"
                            class="input-focus-orange form-check-input checked-orange game-system-check"
                            id="game_system-{{ $game_system->id }}" type="checkbox" value="{{ $game_system->id }}"
                            {{ in_array($game_system->id, old('game_systems', [])) ? 'checked' : '' }}>
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
                <input class="input-focus-orange form-control {{ $errors->has('profile_img') ? 'is-invalid' : '' }}"
                    type="file" accept="image/*" maxlength="2048" id="profile_img" name="profile_img">
                @if ($errors->has('profile_img'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profile_img') }}
                    </div>
                @endif
            </div>
            <div class="d-flex">
                <button id="create-button" type="submit" class="btn btn-void-orange mx-auto">Seems good!</button>
            </div>
        </form>
    </div>
    @vite(['resources/js/checkboxValidation.js'])
@endsection

@push('styles')
    <link href="{{ asset('css/gm-create.css') }}" rel="stylesheet">
@endpush
