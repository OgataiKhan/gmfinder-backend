@extends('layouts.admin')
@section('content')
    <div class="container my-4">
        <form action={{ route('game_master.store') }} method="POST" enctype="multipart/form-data" class="row">
            @csrf
            <div class="col-6 mb-3">
                <label for="location" class="form-label">Location</label>
                <select class="form-select" name="location" id="location">
                    <option selected>Select a province</option>
                    @foreach ($province as $single_province)
                        <option value="{{ $single_province }}" @if (old('single_province') == $single_province) selected @endif>
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
                <textarea class="form-control" id="game_description" rows="3">{{ old('game_description') }}</textarea>
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
