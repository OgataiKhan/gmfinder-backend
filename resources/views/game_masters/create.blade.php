@extends('layouts.admin')
@section('content')
<div class="container my-4">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action={{ route('game_master.store') }} method="POST" enctype="multipart/form-data" class="row">
        @csrf
        <div class="col-6 mb-3">
            <label for="location" class="form-label">Location</label>
            <select class="form-select" name="location" id="location">
                <option value="" disabled selected hidden>Select a province</option>
                @foreach ($province as $single_province)
                <option value="{{ $single_province }}" @if (old('location')==$single_province) selected @endif>
                    {{ $single_province }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 col-6">
            <label for="max_players" class="form-label">Max players</label>
            <input type="number" class="form-control" id="max_players" name="max_players"
                value="{{ old('max_players') }}">
        </div>
        <div class="mb-3">
            <label for="game_description" class="form-label">Game description</label>
            <textarea class="form-control" name="game_description" id="game_description"
                rows="3">{{ old('game_description') }}</textarea>
        </div>
        <div class="mb-3">
            <p class="form-label">Game systems</p>
            @foreach ($game_systems as $game_system)
            <div class="form-check">
                <input name="game_systems[]" class="form-check-input" id="game_system-{{ $game_system->id }}"
                    type="checkbox" value="{{ $game_system->id }}" {{ in_array($game_system->id, old('game_systems',
                [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="game_system-{{ $game_system->id }}">{{ $game_system->name
                    }}</label>
            </div>
            @endforeach
        </div>
        <div class="mb-3 col-12">
            <label for="profile_img" class="form-label">Choose a profile picture</label>
            <input class="form-control" type="file" id="profile_img" name="profile_img">
        </div>
        <div class="col-1 mx-auto">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>
@endsection



<form method="POST" action="{{ route('game_master.store') }}" enctype="multipart/form-data">
    @csrf