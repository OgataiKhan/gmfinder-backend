@extends('layouts.admin')
@section('content')
    <div class="container">

        <form action={{ route('game_master.update', 'game_master') }} method="POST" class="d-flex row p-4 text-light"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="max_players">Insert a players number</label>
            <input type="number" name="max_players" id="max_players">
            <button type="submit" class="btn btn-primary ">Submit</button>
        </form>
    </div>
@endsection
